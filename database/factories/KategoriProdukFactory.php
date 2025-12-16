<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\KategoriProduk>
 */
class KategoriProdukFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $namaKategori = fake()->unique()->words(fake()->numberBetween(2, 4), true);
        return [
            'nama_kategori' => Str::title($namaKategori),
            'deskripsi_kategori' => fake()->sentence(10),
            'slug' => Str::slug($namaKategori),
        ];
    }
}