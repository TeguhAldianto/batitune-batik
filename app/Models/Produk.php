<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

use Illuminate\Database\Eloquent\SoftDeletes;


class Produk extends Model
{
    /** @use HasFactory<\Database\Factories\ProdukFactory> */
    use HasFactory, SoftDeletes;


    protected $fillable = [
        'kategori_produk_id',
        'nama_produk',
        'slug',
        'deskripsi',
        'harga',
        'stok',
        'gambar_produk',
        'motif_batik',
        'jenis_kain',
        'ukuran',
        'warna_dominan',
        'berat_gram'
    ];

    public function kategoriProduk()
    {
        return $this->belongsTo(KategoriProduk::class);
    }

    public function itemKeranjangs()
    {
        return $this->hasMany(ItemKeranjang::class);
    }

    public function detailPesanans()
    {
        return $this->hasMany(DetailPesanan::class);
    }

    public function ulasans(): HasMany
    {
        return $this->hasMany(Ulasan::class);
    }
}
