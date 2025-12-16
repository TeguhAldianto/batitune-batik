<?php

namespace Database\Factories;

use App\Models\Keranjang;
use App\Models\Produk;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ItemKeranjang>
 */
class ItemKeranjangFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $produk = Produk::all()->random(); // Ambil produk random
        return [
            'keranjang_id' => Keranjang::factory(),
            'produk_id' => $produk->id,
            'kuantitas' => fake()->numberBetween(1, min(5, $produk->stok > 0 ? $produk->stok : 1)), 
        ];
    }
}