<?php

namespace Database\Factories;

use App\Models\Pesanan;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pembayaran>
 */
class PembayaranFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $statusPembayaran = fake()->randomElement(['pending', 'sukses', 'gagal']);
        $pesanan = Pesanan::factory()->create(); // Untuk standalone, di seeder akan diambil dari pesanan yg ada

        return [
            'pesanan_id' => $pesanan->id,
            'metode_pembayaran' => $statusPembayaran === 'sukses' ? fake()->randomElement(['Transfer Bank BCA', 'GoPay', 'OVO', 'Midtrans Virtual Account']) : 'Belum Dipilih',
            'status_pembayaran' => $statusPembayaran,
            'jumlah_dibayar' => $pesanan->total_keseluruhan,
            'tanggal_pembayaran' => $statusPembayaran === 'sukses' ? fake()->dateTimeBetween($pesanan->tanggal_pesanan, 'now') : null,
            'bukti_pembayaran' => $statusPembayaran === 'sukses' && str_contains(strtolower($this->faker->randomElement(['Transfer Bank BCA'])), 'transfer') ? 'images/bukti/default.jpg' : null,
            'id_transaksi_gateway' => $statusPembayaran === 'sukses' && !str_contains(strtolower($this->faker->randomElement(['Transfer Bank BCA'])), 'transfer') ? 'TRX-' . Str::upper(Str::random(15)) : null,
            'detail_gateway' => $statusPembayaran === 'sukses' && !str_contains(strtolower($this->faker->randomElement(['Transfer Bank BCA'])), 'transfer') ? json_encode(['status_code' => '200', 'transaction_status' => 'capture']) : null,
        ];
    }
}