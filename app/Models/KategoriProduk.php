<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriProduk extends Model
{
    /** @use HasFactory<\Database\Factories\KategoriProdukFactory> */

    protected $table = 'kategori_produks';

    use HasFactory;

        protected $fillable = ['nama_kategori', 'deskripsi_kategori', 'slug'];

        public function produks() {
            return $this->hasMany(Produk::class);
        }
}
