<?php

namespace Database\Factories;

use App\Models\Pelanggan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Alamat>
 */
class AlamatFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'pelanggan_id' => Pelanggan::factory(),
            'label_alamat' => fake()->randomElement(['Rumah', 'Kantor', 'Apartemen']),
            'nama_penerima' => fake()->name(),
            'no_hp_penerima' => fake()->e164PhoneNumber(),
            'alamat_lengkap' => fake()->streetAddress(),
            'kota' => fake()->city(),
            'provinsi' => fake()->state(),
            'kode_pos' => fake()->postcode(),
            'is_alamat_utama' => fake()->boolean(70), // 70% chance true
        ];
    }
}