<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Metode utama yang akan menampilkan halaman "Home" untuk semua pengguna.
     */
    public function index()
    {
        // Ambil 8 produk terbaru dari database untuk ditampilkan di homepage.
        // Logika ini sekarang dijalankan untuk semua pengguna, baik yang login maupun tidak.
        $produks = Produk::latest()->take(8)->get();

        // Selalu kirim data produk ke view 'home' dan tampilkan halamannya.
        // Tampilan menu yang berbeda (keranjang, profil, dll.) sudah diatur di dalam file view
        // menggunakan directive Blade @auth.
        return view('home', [
            'produks' => $produks
        ]);
    }
}
