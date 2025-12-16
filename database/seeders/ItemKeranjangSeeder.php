<?php

namespace Database\Seeders;

use App\Models\ItemKeranjang;
use App\Models\Keranjang;
use App\Models\Produk;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ItemKeranjangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $keranjangs = Keranjang::all();
        $produks = Produk::where('stok', '>', 0)->get();

        if ($keranjangs->isEmpty() || $produks->isEmpty()) {
            $this->command->info('Tidak ada Keranjang atau Produk tersedia untuk membuat Item Keranjang.');
            return;
        }

        foreach ($keranjangs as $keranjang) {
            // Setiap keranjang punya 0-5 item
            $jumlahItem = fake()->numberBetween(0, 5);
            $produksDitambahkan = []; // Untuk memastikan produk tidak duplikat dalam satu keranjang

            for ($i = 0; $i < $jumlahItem; $i++) {
                $pilihan = $produks->whereNotIn('id', $produksDitambahkan);
                if ($pilihan->isEmpty()) {
                    break;
                }
                $produkRandom = $pilihan->random();
                if ($produkRandom) {
                    ItemKeranjang::factory()->create([
                        'keranjang_id' => $keranjang->id,
                        'produk_id' => $produkRandom->id,
                        'kuantitas' => fake()->numberBetween(1, min(3, $produkRandom->stok)),
                    ]);
                    $produksDitambahkan[] = $produkRandom->id;
                }
            }
        }
    }
}
