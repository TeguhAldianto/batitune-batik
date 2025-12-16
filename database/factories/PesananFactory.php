<?php

namespace Database\Factories;

use App\Models\Alamat;
use App\Models\Pelanggan;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pesanan>
 */
class PesananFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $pelanggan = Pelanggan::all()->random();
        $alamat = $pelanggan->alamats()->where('is_alamat_utama', true)->first() ?? $pelanggan->alamats()->first() ?? Alamat::factory()->create(['pelanggan_id' => $pelanggan->id, 'is_alamat_utama' => true]);

        $totalHargaProduk = fake()->numberBetween(100000, 5000000);
        $biayaPengiriman = fake()->numberBetween(10000, 50000);
        $diskon = fake()->randomElement([0, fake()->numberBetween(5000, $totalHargaProduk / 10)]);

        return [
            'pelanggan_id' => $pelanggan->id,
            'alamat_pengiriman_id' => $alamat->id,
            'kode_pesanan' => 'INV/' . now()->year . '/' . Str::upper(Str::random(3)) . '/' . fake()->unique()->randomNumber(5, true),
            'tanggal_pesanan' => fake()->dateTimeBetween('-3 months', 'now'),
            'status_pesanan' => fake()->randomElement(['menunggu_pembayaran', 'diproses', 'dikirim', 'selesai', 'dibatalkan']),
            'total_harga_produk' => $totalHargaProduk,
            'biaya_pengiriman' => $biayaPengiriman,
            'diskon' => $diskon,
            'total_keseluruhan' => $totalHargaProduk + $biayaPengiriman - $diskon,
            'catatan_pelanggan' => fake()->optional()->sentence(),
            'jasa_pengiriman' => fake()->randomElement(['JNE REG', 'J&T Express', 'SiCepat REG', 'POS Kilat Khusus']),
            'no_resi_pengiriman' => fn (array $attributes) => $attributes['status_pesanan'] === 'dikirim' || $attributes['status_pesanan'] === 'selesai' ? Str::upper(Str::random(12)) : null,
        ];
    }
}