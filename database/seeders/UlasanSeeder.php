<?php

namespace Database\Seeders;

use App\Models\Ulasan;
use App\Models\Pesanan;
use App\Models\Pelanggan;
use App\Models\Produk;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UlasanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pesananSelesai = Pesanan::where('status_pesanan', 'selesai')
                                ->has('detailPesanans.produk') // Pastikan produk di detail pesanan ada
                                ->with('detailPesanans.produk', 'pelanggan') // Eager load relasi
                                ->get();

        if ($pesananSelesai->isEmpty()) {
            $this->command->info('Tidak ada Pesanan yang selesai untuk diberi ulasan.');
            return;
        }

        foreach ($pesananSelesai as $pesanan) {
            foreach ($pesanan->detailPesanans as $detail) {
                // Peluang 50% untuk setiap produk dalam pesanan selesai diberi ulasan
                if (fake()->boolean(50)) {
                    // Cek apakah ulasan untuk kombinasi ini sudah ada
                    $existingUlasan = Ulasan::where('pelanggan_id', $pesanan->pelanggan_id)
                                            ->where('produk_id', $detail->produk_id)
                                            ->where('pesanan_id', $pesanan->id)
                                            ->exists();
                    if (!$existingUlasan && $detail->produk) { // Pastikan produknya tidak null
                        Ulasan::factory()->create([
                            'pelanggan_id' => $pesanan->pelanggan_id,
                            'produk_id' => $detail->produk_id,
                            'pesanan_id' => $pesanan->id,
                        ]);
                    }
                }
            }
        }

        // Tambahkan beberapa ulasan random tanpa pesanan_id (jika diizinkan)
        // Misal untuk produk yang mungkin dibeli offline
        // $pelanggans = Pelanggan::all();
        // $produks = Produk::all();
        // if($pelanggans->isNotEmpty() && $produks->isNotEmpty()){
        //     for ($i=0; $i < 10; $i++) {
        //         $pelanggan = $pelanggans->random();
        //         $produk = $produks->random();
        //          $existingUlasan = Ulasan::where('pelanggan_id', $pelanggan->id)
        //                                     ->where('produk_id', $produk->id)
        //                                     ->whereNull('pesanan_id')
        //                                     ->exists();
        //         if(!$existingUlasan){
        //             Ulasan::factory()->create([
        //                 'pelanggan_id' => $pelanggan->id,
        //                 'produk_id' => $produk->id,
        //                 'pesanan_id' => null,
        //             ]);
        //         }
        //     }
        // }
    }
}