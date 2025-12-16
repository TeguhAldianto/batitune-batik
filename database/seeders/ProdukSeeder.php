<?php

namespace Database\Seeders;

use App\Models\KategoriProduk;
use App\Models\Produk;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategoriProduks = KategoriProduk::all();

        if ($kategoriProduks->isEmpty()) {
            $this->command->info('Tidak ada Kategori Produk. Silakan jalankan KategoriProdukSeeder terlebih dahulu.');
            return;
        }

        foreach ($kategoriProduks as $kategori) {
            Produk::factory()->count(fake()->numberBetween(5,10))->create([
                'kategori_produk_id' => $kategori->id,
            ]);
        }
    }
}