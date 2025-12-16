<?php

namespace Database\Factories;

use App\Models\Pesanan;
use App\Models\Produk;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DetailPesanan>
 */
class DetailPesananFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $produk = Produk::where('stok', '>', 0)->get()->random();
        $kuantitas = fake()->numberBetween(1, min(3, $produk->stok));

        return [
            'pesanan_id' => Pesanan::factory(),
            'produk_id' => $produk->id,
            'nama_produk_saat_pesan' => $produk->nama_produk,
            'kuantitas' => $kuantitas,
            'harga_produk_saat_pesan' => $produk->harga,
            'subtotal_item' => $produk->harga * $kuantitas,
        ];
    }
}