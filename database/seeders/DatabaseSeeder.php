<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            // PelangganSeeder::class,
            // AdminSeeder::class,
            KategoriProdukSeeder::class,
            ProdukSeeder::class,
            AlamatSeeder::class,
            KeranjangSeeder::class,
            ItemKeranjangSeeder::class,
            PesananSeeder::class,
            // DetailPesananSeeder::class,
            // PembayaranSeeder::class,
            UlasanSeeder::class,
        ]);
    }
}
