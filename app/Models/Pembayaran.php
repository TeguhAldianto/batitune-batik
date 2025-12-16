<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    /** @use HasFactory<\Database\Factories\PembayaranFactory> */
    use HasFactory;

    protected $fillable = [
        'pesanan_id', 'metode_pembayaran', 'status_pembayaran', 'jumlah_dibayar',
        'tanggal_pembayaran', 'bukti_pembayaran', 'id_transaksi_gateway', 'detail_gateway'
    ];
    
    protected $casts = [
        'tanggal_pembayaran' => 'datetime',
        'detail_gateway' => 'array',
    ];
    
    public function pesanan() {
        return $this->belongsTo(Pesanan::class);
    }
}
