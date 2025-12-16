<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk; // Pastikan model Produk di-import

class ProdukController extends Controller
{
    /**
     * Menampilkan halaman daftar semua produk.
     * Logika ini harus ada di dalam metode index().
     */
    public function index()
    {
        // Ambil semua produk dengan paginasi (12 produk per halaman)
        $produks = Produk::latest()->paginate(12); // Mengubah nama variabel menjadi jamak (plural)

        return view('produk.index', [
            'produks' => $produks // Mengirim variabel 'produks' ke view
        ]);
    }

    /**
     * Menampilkan halaman detail satu produk.
     * Metode ini sudah benar.
     */
    public function show(Produk $produk) 
    {

        $produk_terkait = Produk::where('kategori_produk_id', $produk->kategori_produk_id)
            ->where('id', '!=', $produk->id) 
            ->limit(4) 
            ->inRandomOrder() 
            ->get();


        return view('produk.show', [
            'produk' => $produk,
            'produk_terkait' => $produk_terkait
        ]);
    }
}
