<?php

namespace Database\Factories;

use App\Models\KategoriProduk;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Produk>
 */
class ProdukFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $namaProduk = fake()->unique()->words(fake()->numberBetween(3, 5), true);
        $jenisKain = ['Katun Prima', 'Katun Primisima', 'Sutra ATBM', 'Dobby'];
        $motifBatik = ['Parang Rusak', 'Kawung', 'Mega Mendung', 'Sekar Jagad', 'Truntum', 'Sidomukti'];

        return [
            'kategori_produk_id' => KategoriProduk::factory(),
            'nama_produk' => Str::title($namaProduk),
            'slug' => Str::slug($namaProduk),
            'deskripsi' => fake()->paragraph(3),
            'harga' => fake()->numberBetween(150000, 2500000),
            'stok' => fake()->numberBetween(5, 50),
            'gambar_produk' => 'images/produk/default.jpg',
            'motif_batik' => fake()->randomElement($motifBatik),
            'jenis_kain' => fake()->randomElement($jenisKain),
            'ukuran' => fake()->randomElement(['S', 'M', 'L', 'XL', 'All Size', '2.5m x 1.15m']),
            'warna_dominan' => fake()->colorName(),
            'berat_gram' => fake()->numberBetween(200, 800),
        ];
    }
}