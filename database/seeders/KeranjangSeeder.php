<?php

namespace Database\Seeders;

use App\Models\Keranjang;
use App\Models\Pelanggan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KeranjangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pelanggans = Pelanggan::doesntHave('keranjang')->get();

        if ($pelanggans->isEmpty()) {
            $this->command->info('Semua pelanggan sudah memiliki keranjang atau tidak ada pelanggan.');
            return;
        }

        foreach ($pelanggans as $pelanggan) {
            Keranjang::factory()->create([
                'pelanggan_id' => $pelanggan->id,
            ]);
        }
    }
}