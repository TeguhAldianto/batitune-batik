<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $pelanggan_id
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @method \Illuminate\Database\Eloquent\Relations\BelongsTo pelanggan()
 * @method \Illuminate\Database\Eloquent\Relations\HasMany itemKeranjangs()
 * @method \Illuminate\Database\Eloquent\Relations\BelongsToMany produks()
 */
class Keranjang extends Model
{
    /** @use HasFactory<\Database\Factories\KeranjangFactory> */
    use HasFactory;

    protected $fillable = ['pelanggan_id'];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    public function itemKeranjangs()
    {
        return $this->hasMany(ItemKeranjang::class);
    }

    public function produks()
    {
        return $this->belongsToMany(Produk::class, 'item_keranjangs')->withPivot('kuantitas')->withTimestamps();
    }
}
