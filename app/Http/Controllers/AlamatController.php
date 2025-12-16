<?php

namespace App\Http\Controllers;

use App\Models\Alamat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AlamatController extends Controller
{
    /**
     * Menampilkan halaman manajemen alamat.
     */
    public function index()
    {
        $alamats = Auth::user()->pelanggan->alamats;
        return view('alamat.index', compact('alamats'));
    }

    /**
     * Menyimpan alamat baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'label_alamat' => 'required|string|max:255',
            'nama_penerima' => 'required|string|max:255',
            'no_hp_penerima' => 'required|string|max:20',
            'alamat_lengkap' => 'required|string',
            'kota' => 'required|string|max:100',
            'provinsi' => 'required|string|max:100',
            'kode_pos' => 'required|string|max:10',
        ]);

        $pelanggan = Auth::user()->pelanggan;

        // Jika ini adalah alamat pertama, jadikan alamat utama
        if ($pelanggan->alamats()->count() == 0) {
            $request['is_alamat_utama'] = true;
        }

        $pelanggan->alamats()->create($request->all());

        return redirect()->route('alamat.index')->with('success', 'Alamat baru berhasil ditambahkan.');
    }

    /**
     * Menghapus alamat.
     */
    public function destroy(Alamat $alamat)
    {
        if ($alamat->pelanggan_id !== Auth::user()->pelanggan->id) {
            abort(403);
        }

        // Jangan izinkan hapus alamat utama jika hanya ada satu alamat
        if ($alamat->is_alamat_utama && Auth::user()->pelanggan->alamats()->count() <= 1) {
            return back()->with('error', 'Tidak dapat menghapus satu-satunya alamat utama.');
        }

        $alamat->delete();

        // Jika yang dihapus adalah alamat utama, jadikan alamat lain sebagai utama
        if ($alamat->is_alamat_utama) {
            $newUtama = Auth::user()->pelanggan->alamats()->first();
            if ($newUtama) {
                $newUtama->update(['is_alamat_utama' => true]);
            }
        }

        return redirect()->route('alamat.index')->with('success', 'Alamat berhasil dihapus.');
    }

    /**
     * Menjadikan sebuah alamat sebagai alamat utama.
     */
    public function setUtama(Alamat $alamat)
    {
        if ($alamat->pelanggan_id !== Auth::user()->pelanggan->id) {
            abort(403);
        }

        // Reset semua alamat lain menjadi tidak utama
        Auth::user()->pelanggan->alamats()->update(['is_alamat_utama' => false]);

        // Set alamat yang dipilih menjadi utama
        $alamat->update(['is_alamat_utama' => true]);

        return redirect()->route('alamat.index')->with('success', 'Alamat utama berhasil diperbarui.');
    }
}