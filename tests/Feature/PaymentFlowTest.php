<?php

// Simple stub to avoid calling external Midtrans service during tests
namespace Midtrans {
    class Snap
    {
        public static function getSnapToken($payload)
        {
            return 'DUMMY_TOKEN';
        }
    }
}

namespace Tests\Feature {

    use App\Http\Controllers\PembayaranController;
    use App\Models\Alamat;
    use App\Models\ItemKeranjang;
    use App\Models\Keranjang;
    use App\Models\Pelanggan;
    use App\Models\Pembayaran;
    use App\Models\Pesanan;
    use App\Models\Produk;
    use App\Models\User;
    use Illuminate\Foundation\Testing\RefreshDatabase;
    use Illuminate\Http\Request;
    use Tests\TestCase;

    class PaymentFlowTest extends TestCase
    {
        use RefreshDatabase;

        public function test_checkout_creates_order_and_payment()
        {
            // Configure Midtrans keys for the controller to proceed
            config(['midtrans.server_key' => 'test-server-key', 'midtrans.client_key' => 'test-client-key']);

            $user = User::factory()->create(['email_verified_at' => now()]);
            $pelanggan = Pelanggan::factory()->create(['user_id' => $user->id]);
            $alamat = Alamat::factory()->create(['pelanggan_id' => $pelanggan->id]);

            $produk = Produk::factory()->create(['stok' => 5, 'harga' => 100000]);

            $keranjang = Keranjang::factory()->create(['pelanggan_id' => $pelanggan->id]);
            ItemKeranjang::factory()->create(['keranjang_id' => $keranjang->id, 'produk_id' => $produk->id, 'kuantitas' => 2]);

            // Panggil controller langsung supaya tidak tergantung pada session driver saat testing
            $controller = new PembayaranController();

            // Pastikan Laravel mengenal user yang sedang login
            \Illuminate\Support\Facades\Auth::setUser($user);

            $request = Request::create('/checkout/proses', 'POST', ['alamat_pengiriman_id' => $alamat->id]);

            $response = $controller->prosesPesanan($request);

            $this->assertEquals(200, $response->getStatusCode());
            $this->assertEquals('DUMMY_TOKEN', $response->getData()->snap_token ?? null);

            // Pesanan dibuat dan pembayaran pending
            $this->assertDatabaseHas('pesanans', ['status_pesanan' => 'menunggu_pembayaran']);
            $this->assertDatabaseHas('pembayarans', ['status_pembayaran' => 'pending']);
        }

        public function test_webhook_success_marks_payment_sukses()
        {
            $produk = Produk::factory()->create(['stok' => 10, 'harga' => 50000]);

            $user = User::factory()->create();
            $pelanggan = Pelanggan::factory()->create(['user_id' => $user->id]);
            $alamat = Alamat::factory()->create(['pelanggan_id' => $pelanggan->id]);

            $pesanan = Pesanan::create([
                'pelanggan_id' => $pelanggan->id,
                'alamat_pengiriman_id' => $alamat->id,
                'kode_pesanan' => 'BTM-TEST-1',
                'tanggal_pesanan' => now(),
                'status_pesanan' => 'menunggu_pembayaran',
                'total_harga_produk' => 100000,
                'biaya_pengiriman' => 15000,
                'total_keseluruhan' => 115000,
            ]);

            $pembayaran = Pembayaran::create([
                'pesanan_id' => $pesanan->id,
                'status_pembayaran' => 'pending',
                'jumlah_dibayar' => 115000,
                'metode_pembayaran' => 'menunggu',
            ]);

            $notification = (object) [
                'transaction_status' => 'settlement',
                'order_id' => $pesanan->kode_pesanan,
                'fraud_status' => 'accept',
                'payment_type' => 'bank_transfer',
                'transaction_id' => 'TX-12345',
                'gross_amount' => 115000,
            ];

            $controller = new PembayaranController();
            $response = $controller->notificationHandler(Request::create('/midtrans/notification', 'POST', []), $notification);

            $this->assertEquals(200, $response->getStatusCode());

            $pembayaran->refresh();
            $pesanan->refresh();

            $this->assertEquals('sukses', $pembayaran->status_pembayaran);
            $this->assertEquals('diproses', $pesanan->status_pesanan);
            $this->assertEquals('TX-12345', $pembayaran->id_transaksi_gateway);
        }

        public function test_duplicate_notification_is_idempotent()
        {
            $user = User::factory()->create();
            $pelanggan = Pelanggan::factory()->create(['user_id' => $user->id]);
            $alamat = Alamat::factory()->create(['pelanggan_id' => $pelanggan->id]);

            $pesanan = Pesanan::create([
                'pelanggan_id' => $pelanggan->id,
                'alamat_pengiriman_id' => $alamat->id,
                'kode_pesanan' => 'BTM-TEST-2',
                'tanggal_pesanan' => now(),
                'status_pesanan' => 'menunggu_pembayaran',
                'total_harga_produk' => 50000,
                'biaya_pengiriman' => 15000,
                'total_keseluruhan' => 65000,
            ]);

            $pembayaran = Pembayaran::create([
                'pesanan_id' => $pesanan->id,
                'status_pembayaran' => 'pending',
                'jumlah_dibayar' => 65000,
                'metode_pembayaran' => 'menunggu',
            ]);

            $notification = (object) [
                'transaction_status' => 'settlement',
                'order_id' => $pesanan->kode_pesanan,
                'fraud_status' => 'accept',
                'payment_type' => 'bank_transfer',
                'transaction_id' => 'TX-222',
                'gross_amount' => 65000,
            ];

            $controller = new PembayaranController();
            $response1 = $controller->notificationHandler(Request::create('/midtrans/notification', 'POST', []), $notification);
            $this->assertEquals(200, $response1->getStatusCode());

            $response2 = $controller->notificationHandler(Request::create('/midtrans/notification', 'POST', []), $notification);
            $this->assertEquals(200, $response2->getStatusCode());

            $pembayaran->refresh();
            $this->assertEquals('sukses', $pembayaran->status_pembayaran);
        }

        public function test_amount_mismatch_returns_400()
        {
            $user = User::factory()->create();
            $pelanggan = Pelanggan::factory()->create(['user_id' => $user->id]);
            $alamat = Alamat::factory()->create(['pelanggan_id' => $pelanggan->id]);

            $pesanan = Pesanan::create([
                'pelanggan_id' => $pelanggan->id,
                'alamat_pengiriman_id' => $alamat->id,
                'kode_pesanan' => 'BTM-TEST-3',
                'tanggal_pesanan' => now(),
                'status_pesanan' => 'menunggu_pembayaran',
                'total_harga_produk' => 70000,
                'biaya_pengiriman' => 15000,
                'total_keseluruhan' => 85000,
            ]);

            $pembayaran = Pembayaran::create([
                'pesanan_id' => $pesanan->id,
                'status_pembayaran' => 'pending',
                'jumlah_dibayar' => 85000,
                'metode_pembayaran' => 'menunggu',
            ]);

            $notification = (object) [
                'transaction_status' => 'settlement',
                'order_id' => $pesanan->kode_pesanan,
                'fraud_status' => 'accept',
                'payment_type' => 'bank_transfer',
                'transaction_id' => 'TX-333',
                'gross_amount' => 12345, // mismatch
            ];

            $controller = new PembayaranController();
            $response = $controller->notificationHandler(Request::create('/midtrans/notification', 'POST', []), $notification);

            $this->assertEquals(400, $response->getStatusCode());

            $pembayaran->refresh();
            $this->assertEquals('pending', $pembayaran->status_pembayaran);
        }

        public function test_cancel_notification_cancels_order_and_restores_stock()
        {
            $produk = Produk::factory()->create(['stok' => 3, 'harga' => 50000]);

            $user = User::factory()->create();
            $pelanggan = Pelanggan::factory()->create(['user_id' => $user->id]);
            $alamat = Alamat::factory()->create(['pelanggan_id' => $pelanggan->id]);

            $pesanan = Pesanan::create([
                'pelanggan_id' => $pelanggan->id,
                'alamat_pengiriman_id' => $alamat->id,
                'kode_pesanan' => 'BTM-TEST-4',
                'tanggal_pesanan' => now(),
                'status_pesanan' => 'menunggu_pembayaran',
                'total_harga_produk' => 50000,
                'biaya_pengiriman' => 15000,
                'total_keseluruhan' => 65000,
            ]);

            // create a detail and decrement stock to simulate order already placed
            $pesanan->detailPesanans()->create([
                'produk_id' => $produk->id,
                'nama_produk_saat_pesan' => $produk->nama_produk,
                'kuantitas' => 2,
                'harga_produk_saat_pesan' => $produk->harga,
                'subtotal_item' => 2 * $produk->harga,
            ]);

            // decrement stock as order did
            $produk->decrement('stok', 2);

            $pembayaran = Pembayaran::create([
                'pesanan_id' => $pesanan->id,
                'status_pembayaran' => 'pending',
                'jumlah_dibayar' => 65000,
                'metode_pembayaran' => 'menunggu',
            ]);

            $notification = (object) [
                'transaction_status' => 'expire',
                'order_id' => $pesanan->kode_pesanan,
                'fraud_status' => 'deny',
                'payment_type' => 'bank_transfer',
                'transaction_id' => 'TX-444',
                'gross_amount' => 65000,
            ];

            $controller = new PembayaranController();
            $response = $controller->notificationHandler(Request::create('/midtrans/notification', 'POST', []), $notification);

            $this->assertEquals(200, $response->getStatusCode());

            $pesanan->refresh();
            $produk->refresh();
            $pembayaran->refresh();

            $this->assertEquals('dibatalkan', $pesanan->status_pesanan);
            $this->assertEquals('gagal', $pembayaran->status_pembayaran);
            $this->assertEquals(3, $produk->stok); // restored stock
        }
    }
}
