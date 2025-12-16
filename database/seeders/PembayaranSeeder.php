<?php

namespace Database\Seeders;

use App\Models\Pembayaran;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PembayaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pembayaran::factory()->count(20)->create(); // Logika ini lebih kompleks, terkait Pesanan yang statusnya sesuai.
        // Sebaiknya dibuat bersamaan dengan PesananSeeder.
    }
}