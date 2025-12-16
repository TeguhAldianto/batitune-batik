<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemKeranjang extends Model
{
    /** @use HasFactory<\Database\Factories\ItemKeranjangFactory> */
    use HasFactory;

    protected $fillable = ['keranjang_id', 'produk_id', 'kuantitas'];

    public function keranjang() {
        return $this->belongsTo(Keranjang::class);
    }

    public function produk() {
        return $this->belongsTo(Produk::class);
    }
}
