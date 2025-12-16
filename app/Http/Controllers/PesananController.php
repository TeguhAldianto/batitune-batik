<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PesananController extends Controller
{
    /**
     * Menampilkan halaman riwayat pesanan milik pengguna.
     */
    public function index()
    {
        $pelanggan = Auth::user()->pelanggan;
        
        // Ambil semua pesanan milik pelanggan, urutkan dari yang terbaru
        $pesanans = Pesanan::where('pelanggan_id', $pelanggan->id)
                            ->latest()
                            ->paginate(10);

        return view('pesanan.index', compact('pesanans'));
    }

    /**
     * Menampilkan detail dari satu pesanan spesifik.
     */
    public function show(Pesanan $pesanan)
    {
        // Pastikan pesanan ini adalah milik pengguna yang sedang login
        if ($pesanan->pelanggan_id !== Auth::user()->pelanggan->id) {
            abort(403, 'AKSES DITOLAK');
        }

        // Eager load relasi untuk efisiensi query
        $pesanan->load('detailPesanans.produk', 'pembayaran', 'alamatPengiriman');

        return view('pesanan.show', compact('pesanan'));
    }
}