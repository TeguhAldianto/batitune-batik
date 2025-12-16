<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property string|null $no_hp
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @method \Illuminate\Database\Eloquent\Relations\BelongsTo user()
 * @method \Illuminate\Database\Eloquent\Relations\HasMany alamats()
 * @method \Illuminate\Database\Eloquent\Relations\HasOne keranjang()
 * @method \Illuminate\Database\Eloquent\Relations\HasMany pesanans()
 * @method \Illuminate\Database\Eloquent\Relations\HasMany ulasans()
 */
class Pelanggan extends Model
{
    /** @use HasFactory<\Database\Factories\PelangganFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'no_hp'
    ];

    /**
     * Get the user that owns the pelanggan.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all of the alamats for the Pelanggan.
     */
    public function alamats()
    {
        return $this->hasMany(Alamat::class);
    }

    /**
     * Get the keranjang associated with the Pelanggan.
     */
    public function keranjang() // Satu pelanggan punya satu keranjang
    {
        return $this->hasOne(Keranjang::class);
    }

    /**
     * Get all of the pesanans for the Pelanggan.
     */
    public function pesanans()
    {
        return $this->hasMany(Pesanan::class);
    }

    /**
     * Get all of the ulasans for the Pelanggan.
     */
    public function ulasans()
    {
        return $this->hasMany(Ulasan::class);
    }
}
