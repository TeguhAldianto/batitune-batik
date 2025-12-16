<?php

namespace Database\Seeders;

use App\Models\Pesanan;
use App\Models\Pelanggan;
use App\Models\Alamat;
use App\Models\Produk;
use App\Models\DetailPesanan;
use App\Models\Pembayaran;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PesananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pelanggans = Pelanggan::has('alamats')->get(); // Hanya pelanggan yang punya alamat

        if ($pelanggans->isEmpty()) {
            $this->command->info('Tidak ada Pelanggan dengan Alamat. Jalankan AlamatSeeder.');
            return;
        }
        $produks = Produk::where('stok', '>', 0)->get();
        if ($produks->isEmpty()) {
            $this->command->info('Tidak ada Produk tersedia. Jalankan ProdukSeeder.');
            return;
        }


        foreach ($pelanggans as $pelanggan) {
            // Setiap pelanggan punya 1-5 pesanan
            Pesanan::factory()->count(fake()->numberBetween(1,5))->create([
                'pelanggan_id' => $pelanggan->id,
                'alamat_pengiriman_id' => $pelanggan->alamats()->inRandomOrder()->first()->id,
            ])->each(function (Pesanan $pesanan) use ($produks) {
                // Buat DetailPesanan untuk setiap Pesanan
                $jumlahDetail = fake()->numberBetween(1, 4);
                $totalHargaProdukPesanan = 0;
                $produksDitambahkan = [];

                for ($i=0; $i < $jumlahDetail; $i++) {
                    $produkRandom = $produks->whereNotIn('id', $produksDitambahkan)->where('stok', '>',0)->random();
                    if($produkRandom){
                        $kuantitas = fake()->numberBetween(1, min(2, $produkRandom->stok));
                        $subtotal = $produkRandom->harga * $kuantitas;
                        DetailPesanan::factory()->create([
                            'pesanan_id' => $pesanan->id,
                            'produk_id' => $produkRandom->id,
                            'nama_produk_saat_pesan' => $produkRandom->nama_produk,
                            'harga_produk_saat_pesan' => $produkRandom->harga,
                            'kuantitas' => $kuantitas,
                            'subtotal_item' => $subtotal,
                        ]);
                        $totalHargaProdukPesanan += $subtotal;
                        $produksDitambahkan[] = $produkRandom->id;

                        // Kurangi stok produk (opsional, tergantung logika bisnis)
                        // $produkRandom->decrement('stok', $kuantitas);
                    }
                }
                // Update total harga produk di pesanan
                $pesanan->total_harga_produk = $totalHargaProdukPesanan;
                $pesanan->total_keseluruhan = $totalHargaProdukPesanan + $pesanan->biaya_pengiriman - $pesanan->diskon;
                $pesanan->save();

                // Buat Pembayaran untuk setiap Pesanan
                if ($pesanan->status_pesanan !== 'dibatalkan' && $pesanan->status_pesanan !== 'menunggu_pembayaran') {
                    Pembayaran::factory()->create([
                        'pesanan_id' => $pesanan->id,
                        'jumlah_dibayar' => $pesanan->total_keseluruhan,
                        'status_pembayaran' => $pesanan->status_pesanan === 'selesai' || $pesanan->status_pesanan === 'dikirim' || $pesanan->status_pesanan === 'diproses' ? 'sukses' : 'pending',
                    ]);
                } elseif ($pesanan->status_pesanan === 'menunggu_pembayaran') {
                     Pembayaran::factory()->create([
                        'pesanan_id' => $pesanan->id,
                        'jumlah_dibayar' => $pesanan->total_keseluruhan,
                        'status_pembayaran' => 'pending',
                        'metode_pembayaran' => 'Belum Dipilih',
                        'tanggal_pembayaran' => null,
                    ]);
                }

            });
        }
    }
}
