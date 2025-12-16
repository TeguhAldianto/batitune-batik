<?php

namespace App\Http\Controllers;

use App\Models\KategoriProduk;
use Illuminate\Http\Request;

class KategoriProdukController extends Controller
{
    /**
     * Menampilkan produk berdasarkan kategori.
     */
    public function show(KategoriProduk $kategoriProduk)
    {
        // Ambil produk yang termasuk dalam kategori ini, dengan paginasi
        $produks = $kategoriProduk->produks()->latest()->paginate(12);

        return view('kategori.show', [
            'kategori' => $kategoriProduk,
            'produks' => $produks,
        ]);
    }
}