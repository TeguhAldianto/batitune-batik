<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\Produk;
use App\Models\Ulasan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UlasanController extends Controller
{
    /**
     * Menyimpan ulasan baru yang dikirim oleh pelanggan.
     */
    public function store(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|exists:produks,id',
            'pesanan_id' => 'required|exists:pesanans,id',
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'nullable|string|max:1000',
        ]);

        $pelanggan = Auth::user()->pelanggan;
        $pesanan = Pesanan::find($request->pesanan_id);

        // --- Keamanan ---
        // 1. Pastikan pesanan ini milik pelanggan yang sedang login
        if ($pesanan->pelanggan_id !== $pelanggan->id) {
            return back()->with('error', 'Anda tidak bisa memberi ulasan untuk pesanan ini.');
        }

        // 2. Pastikan pesanan sudah selesai
        if ($pesanan->status_pesanan !== 'selesai') {
            return back()->with('error', 'Anda hanya bisa memberi ulasan untuk pesanan yang sudah selesai.');
        }

        // 3. Pastikan pelanggan belum pernah memberi ulasan untuk produk ini di pesanan ini
        $ulasanSudahAda = Ulasan::where('pelanggan_id', $pelanggan->id)
                                ->where('produk_id', $request->produk_id)
                                ->where('pesanan_id', $request->pesanan_id)
                                ->exists();

        if ($ulasanSudahAda) {
            return back()->with('error', 'Anda sudah pernah memberikan ulasan untuk produk ini.');
        }

        // Simpan ulasan
        Ulasan::create([
            'pelanggan_id' => $pelanggan->id,
            'produk_id' => $request->produk_id,
            'pesanan_id' => $request->pesanan_id,
            'rating' => $request->rating,
            'komentar' => $request->komentar,
            'is_approved' => false, // Perlu persetujuan admin
        ]);

        return redirect()->route('pesanan.show', $pesanan)->with('success', 'Terima kasih atas ulasan Anda!');
    }
}