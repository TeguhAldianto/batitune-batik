<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ulasan extends Model
{
    /** @use HasFactory<\Database\Factories\UlasanFactory> */
    use HasFactory;

    protected $fillable = [
        'pelanggan_id',
        'produk_id',
        'pesanan_id',
        'rating', // 1-5
        'komentar',
        'is_approved', // 0 atau 1
    ];
    
    public function pelanggan() {
        return $this->belongsTo(Pelanggan::class);
    }
    
    public function produk() {
        return $this->belongsTo(Produk::class);
    }
    
    public function pesanan() {
        return $this->belongsTo(Pesanan::class); 
    }
}
