<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    /** @use HasFactory<\Database\Factories\PesananFactory> */
    use HasFactory;

    protected $fillable = [
        'pelanggan_id', 'alamat_pengiriman_id', 'kode_pesanan', 'tanggal_pesanan', 'status_pesanan',
        'total_harga_produk', 'biaya_pengiriman', 'diskon', 'total_keseluruhan',
        'catatan_pelanggan', 'jasa_pengiriman', 'no_resi_pengiriman'
    ];
    
    protected $casts = [
        'tanggal_pesanan' => 'datetime',
    ];
    
    public function pelanggan() {
        return $this->belongsTo(Pelanggan::class);
    }
    
    public function alamatPengiriman() {
        return $this->belongsTo(Alamat::class, 'alamat_pengiriman_id');
    }
    
    public function detailPesanans() {
        return $this->hasMany(DetailPesanan::class);
    }
    
    public function pembayaran() { // Satu pesanan punya satu pembayaran
        return $this->hasOne(Pembayaran::class);
    }
    
    public function ulasans() {
        return $this->hasMany(Ulasan::class);
    }
}
