<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPesanan extends Model
{
    /** @use HasFactory<\Database\Factories\DetailPesananFactory> */
    use HasFactory;

    protected $fillable = [
        'pesanan_id', 'produk_id', 'nama_produk_saat_pesan',
        'kuantitas', 'harga_produk_saat_pesan', 'subtotal_item'
    ];
    
    public function pesanan() {
        return $this->belongsTo(Pesanan::class);
    }
    
    public function produk() {
        return $this->belongsTo(Produk::class);
    }
}
