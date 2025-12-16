<?php

namespace Database\Factories;

use App\Models\Pelanggan;
use App\Models\Pesanan;
use App\Models\Produk;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ulasan>
 */
class UlasanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $pesananSelesai = Pesanan::where('status_pesanan', 'selesai')
                                ->has('detailPesanans')
                                ->inRandomOrder()
                                ->first();

        if ($pesananSelesai) {
            $pelanggan = $pesananSelesai->pelanggan;
            $produkDiPesanan = $pesananSelesai->detailPesanans()->inRandomOrder()->first()->produk;
        } else {
            $pelanggan = Pelanggan::all()->random();
            $produkDiPesanan = Produk::all()->random();
            $pesananSelesai = null; 
        }


        return [
            'pelanggan_id' => $pelanggan->id,
            'produk_id' => $produkDiPesanan->id,
            'pesanan_id' => $pesananSelesai ? $pesananSelesai->id : null, 
            'rating' => fake()->numberBetween(3, 5),
            'komentar' => fake()->paragraph(2),
            'is_approved' => fake()->boolean(90), // 90% disetujui
        ];
    }
}