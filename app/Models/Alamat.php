<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alamat extends Model
{
    /** @use HasFactory<\Database\Factories\AlamatFactory> */
    use HasFactory;

    protected $fillable = [
        'pelanggan_id', 'label_alamat', 'nama_penerima', 'no_hp_penerima',
        'alamat_lengkap', 'kota', 'provinsi', 'kode_pos', 'is_alamat_utama'
    ];
    
    public function pelanggan() {
        return $this->belongsTo(Pelanggan::class);
    }
    
}
