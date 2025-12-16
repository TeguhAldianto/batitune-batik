<?php

namespace Database\Seeders;

use App\Models\Alamat;
use App\Models\Pelanggan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AlamatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pelanggans = Pelanggan::all();

        if ($pelanggans->isEmpty()) {
            $this->command->info('Tidak ada Pelanggan. Pastikan UserSeeder (pelanggan) sudah dijalankan.');
            return;
        }

        foreach ($pelanggans as $pelanggan) {
            // Setiap pelanggan punya 1-3 alamat
            Alamat::factory()->count(fake()->numberBetween(1, 3))->create([
                'pelanggan_id' => $pelanggan->id,
                // Pastikan setidaknya satu alamat utama per pelanggan jika diperlukan
            ])->each(function ($alamat, $index) use ($pelanggan) {
                if ($index === 0) { // Jadikan alamat pertama sebagai utama
                    $alamat->update(['is_alamat_utama' => true]);
                }
                 // Pastikan hanya ada satu alamat utama per pelanggan
                if ($alamat->is_alamat_utama) {
                    $pelanggan->alamats()->where('id', '!=', $alamat->id)->update(['is_alamat_utama' => false]);
                }
            });
        }
    }
}