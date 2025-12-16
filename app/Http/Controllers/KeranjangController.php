<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Produk;
use App\Models\Keranjang;
use App\Models\ItemKeranjang;
use App\Models\Pelanggan;
use App\Models\User; // Pastikan ini ter-import
use Exception;

class KeranjangController extends Controller
{
    /**
     * Menampilkan halaman keranjang belanja milik pengguna yang sedang login.
     */
    public function index()
    {
        if (!Auth::check()) {
            return redirect('/')->with('error', 'Silakan login terlebih dahulu.');
        }

        /** * FIX: Memberi tahu IDE bahwa $user adalah Model User app kita
         * @var \App\Models\User $user
         */
        $user = Auth::user();

        // Cek apakah user punya pelanggan, jika tidak buat baru
        // Menggunakan method create() via relasi untuk keamanan
        $pelanggan = $user->pelanggan ?? $user->pelanggan()->create([
            'no_hp' => $user->phone ?? null,
        ]);

        /** * FIX: Memberi tahu IDE bahwa $keranjang adalah Model Keranjang
         * @var \App\Models\Keranjang|null $keranjang
         */
        $keranjang = $pelanggan->keranjang()->with('itemKeranjangs.produk')->first();

        return view('keranjang.index', compact('keranjang'));
    }

    /**
     * Menambahkan produk ke keranjang belanja.
     */
    public function tambahKeKeranjang(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|exists:produks,id',
            'kuantitas' => 'required|integer|min:1',
        ]);

        try {
            if (!Auth::check()) {
                return response()->json(['message' => 'Silakan login terlebih dahulu.'], 401);
            }

            /** @var \App\Models\User $user */
            $user = Auth::user();

            // Pastikan data pelanggan ada
            $pelanggan = $user->pelanggan ?? $user->pelanggan()->create([
                'no_hp' => $user->phone ?? null,
            ]);

            $produk = Produk::findOrFail($request->produk_id);

            if ($produk->stok < $request->kuantitas) {
                return response()->json(['message' => 'Maaf, stok produk tidak mencukupi.'], 422);
            }

            // Cari atau buat keranjang
            /** @var \App\Models\Keranjang $keranjang */
            $keranjang = Keranjang::firstOrCreate(['pelanggan_id' => $pelanggan->id]);

            // Cek item di keranjang
            $itemDiKeranjang = $keranjang->itemKeranjangs()->where('produk_id', $produk->id)->first();

            if ($itemDiKeranjang) {
                $itemDiKeranjang->increment('kuantitas', $request->kuantitas);
            } else {
                $keranjang->itemKeranjangs()->create([
                    'produk_id' => $produk->id,
                    'kuantitas' => $request->kuantitas,
                ]);
            }

            return response()->json([
                'message' => 'Produk berhasil ditambahkan ke keranjang!',
                'total_items' => $keranjang->itemKeranjangs()->sum('kuantitas'),
            ], 200);

        } catch (Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Perbarui kuantitas sebuah item di keranjang.
     */
    public function update(Request $request, ItemKeranjang $itemKeranjang)
    {
        $request->validate([
            'kuantitas' => 'required|integer|min:0',
        ]);

        if (!Auth::check()) {
            return $request->wantsJson()
                ? response()->json(['message' => 'Silakan login terlebih dahulu.'], 401)
                : redirect()->route('login');
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Validasi kepemilikan item keranjang
        // Kita cek apakah itemKeranjang ini milik keranjang user yang sedang login

        // Ambil keranjang user saat ini
        $pelanggan = $user->pelanggan;
        $keranjangUser = $pelanggan ? $pelanggan->keranjang : null;

        // Validasi: Apakah user punya keranjang? Dan apakah item ini ada di keranjang user tsb?
        if (!$keranjangUser || $itemKeranjang->keranjang_id !== $keranjangUser->id) {
            return $request->wantsJson()
                ? response()->json(['message' => 'Akses ditolak atau item tidak ditemukan.'], 403)
                : redirect()->route('keranjang.index')->with('error', 'Akses ditolak.');
        }

        $newQty = (int) $request->input('kuantitas', 0);

        if ($newQty <= 0) {
            $itemKeranjang->delete();
            $message = 'Item dihapus dari keranjang.';
        } else {
            // Cek stok
            if ($itemKeranjang->produk && $itemKeranjang->produk->stok < $newQty) {
                return $request->wantsJson()
                    ? response()->json(['message' => 'Stok produk tidak mencukupi.'], 422)
                    : redirect()->back()->with('error', 'Stok tidak cukup.');
            }

            $itemKeranjang->kuantitas = $newQty;
            $itemKeranjang->save();
            $message = 'Kuantitas berhasil diperbarui.';
        }

        return $request->wantsJson()
            ? response()->json(['message' => $message, 'kuantitas' => $newQty], 200)
            : redirect()->route('keranjang.index')->with('success', $message);
    }

    /**
     * Hapus item dari keranjang.
     */
    public function destroy(Request $request, ItemKeranjang $itemKeranjang)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();

        $pelanggan = $user->pelanggan;
        $keranjangUser = $pelanggan ? $pelanggan->keranjang : null;

        // Validasi kepemilikan
        if (!$keranjangUser || $itemKeranjang->keranjang_id !== $keranjangUser->id) {
             return $request->wantsJson()
                ? response()->json(['message' => 'Item tidak ditemukan.'], 404)
                : redirect()->route('keranjang.index')->with('error', 'Gagal menghapus item.');
        }

        $itemKeranjang->delete();

        return $request->wantsJson()
            ? response()->json(['message' => 'Item berhasil dihapus.'], 200)
            : redirect()->route('keranjang.index')->with('success', 'Item berhasil dihapus.');
    }
}
