<?php

namespace Database\Factories;

use App\Models\Pelanggan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Keranjang>
 */
class KeranjangFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // pelanggan_id harus unik, jadi pastikan pelanggan belum punya keranjang
            // Ini akan di-handle di seeder
            // 'pelanggan_id' => Pelanggan::factory(),
        ];
    }
}