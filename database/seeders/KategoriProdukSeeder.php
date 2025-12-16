<?php

namespace Database\Seeders;

use App\Models\KategoriProduk;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class KategoriProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategori = [
            'Batik Tulis Klasik',
            'Batik Tulis Modern',
            'Batik Kombinasi',
            'Kain Batik Meteran'
        ];

        foreach ($kategori as $nama) {
            KategoriProduk::factory()->create([
                'nama_kategori' => $nama,
                'slug' => Str::slug($nama),
            ]);
        }
    }
}