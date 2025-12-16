<?php

namespace App\Http\Controllers;

use App\Mail\OrderCreatedMail;
use App\Mail\PaymentConfirmedMail;
use App\Models\Alamat;
use App\Models\Pelanggan;
use App\Models\Pesanan;
use App\Models\User; // Tambahkan ini agar Model User dikenali
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class PembayaranController extends Controller
{
    /**
     * Mengatur konfigurasi Midtrans saat controller diinisialisasi.
     */
    public function __construct()
    {
        $this->initMidtransConfig();
    }

    /**
     * Inisialisasi konfigurasi Midtrans dengan fallback env dan aman bila kosong.
     */
    protected function initMidtransConfig(): void
    {
        $serverKey = config('midtrans.server_key') ?: env('MIDTRANS_SERVER_KEY');
        $clientKey = config('midtrans.client_key') ?: env('MIDTRANS_CLIENT_KEY');

        if (empty($serverKey) || empty($clientKey)) {
            Log::warning('Midtrans key belum dikonfigurasi. Pembayaran dinonaktifkan.', [
                'config_server_key' => (bool) $serverKey,
                'config_client_key' => (bool) $clientKey,
            ]);
            return;
        }

        \Midtrans\Config::$serverKey = $serverKey;
        \Midtrans\Config::$clientKey = $clientKey;
        \Midtrans\Config::$isProduction = config('midtrans.is_production', false);
        \Midtrans\Config::$isSanitized = config('midtrans.is_sanitized', true);
        \Midtrans\Config::$is3ds = config('midtrans.is_3ds', true);
    }

    /**
     * Pastikan Midtrans siap sebelum memproses pembayaran.
     */
    protected function ensureMidtransReady(): bool
    {
        if (empty(\Midtrans\Config::$serverKey) || empty(\Midtrans\Config::$clientKey)) {
            return false;
        }
        return true;
    }

    /**
     * Menampilkan halaman checkout.
     */
    public function checkout()
    {
        if (!$this->ensureMidtransReady()) {
            Log::warning('Checkout diakses saat Midtrans tidak terkonfigurasi', ['user_id' => Auth::id()]);
            return redirect()->route('produk.index')->with('error', 'Pembayaran sementara tidak tersedia. Kami sedang menyelesaikan konfigurasi. Silakan coba lagi dalam beberapa saat atau hubungi customer service kami.');
        }

        /** * FIX: Memberi tahu IDE bahwa user ini adalah instance dari App\Models\User
         * @var User $user
         */
        $user = Auth::user();

        // Menggunakan variabel $user yang sudah di-typehint
        $pelanggan = $user->pelanggan ?? $user->pelanggan()->create([
            'no_hp' => $user->phone ?? null,
        ]);

        $keranjang = $pelanggan->keranjang()->with('itemKeranjangs.produk')->first();

        // Jika keranjang kosong, redirect ke halaman produk
        if (!$keranjang || $keranjang->itemKeranjangs->isEmpty()) {
            Log::info('User mencoba checkout dengan keranjang kosong', ['user_id' => Auth::id(), 'pelanggan_id' => $pelanggan->id]);
            return redirect()->route('produk.index')->with('error', 'Keranjang Anda kosong. Silakan pilih produk yang ingin dibeli terlebih dahulu.');
        }

        // Ambil alamat pelanggan
        $alamats = $pelanggan->alamats;

        // Jika tidak punya alamat, redirect ke halaman manajemen alamat
        if ($alamats->isEmpty()) {
            Log::info('User mencoba checkout tanpa alamat terdata', ['user_id' => Auth::id(), 'pelanggan_id' => $pelanggan->id]);
            return redirect()->route('alamat.index')->with('error', 'Anda perlu menambahkan alamat pengiriman terlebih dahulu. Silakan isi data alamat dengan lengkap.');
        }

        return view('pembayaran.checkout', [
            'keranjang' => $keranjang,
            'alamats' => $alamats,
        ]);
    }

    /**
     * Memproses pesanan dari checkout dan menghasilkan token Midtrans.
     */
    public function prosesPesanan(Request $request)
    {
        try {
            if (!$this->ensureMidtransReady()) {
                Log::error('Checkout dipicu saat Midtrans tidak siap', ['user_id' => Auth::id()]);
                return response()->json([
                    'error' => 'Layanan pembayaran sementara tidak tersedia. Kami sedang melakukan perbaikan. Silakan coba lagi dalam beberapa saat.'
                ], 503);
            }

            $request->validate([
                'alamat_pengiriman_id' => 'required|exists:alamats,id',
            ]);

            /** * FIX: Memberi tahu IDE bahwa user ini adalah instance dari App\Models\User
             * @var User $user
             */
            $user = Auth::user();

            /** @var \App\Models\Pelanggan $pelanggan */
            // Pastikan kita selalu mengambil pelanggan dari DB (hindari cache relation yang mungkin null)
            $pelanggan = Pelanggan::firstOrCreate([
                'user_id' => $user->id,
            ], [
                'no_hp' => $user->phone ?? null,
            ]);

            $keranjang = $pelanggan->keranjang()->with('itemKeranjangs.produk')->first();
            $alamat = Alamat::find($request->alamat_pengiriman_id);

            // Keamanan: Pastikan alamat ini milik pelanggan yang sedang login
            if (! $alamat || $alamat->pelanggan_id !== $pelanggan->id) {
                Log::warning('User mencoba checkout dengan alamat orang lain', [
                    'user_id' => Auth::id(),
                    'alamat_id' => $request->alamat_pengiriman_id,
                    'expected_pelanggan_id' => $pelanggan->id,
                    'actual_pelanggan_id' => $alamat->pelanggan_id ?? null,
                ]);

                abort(403);
            }

            // Validasi stok di sisi server sebelum membuat pesanan (menghindari overselling)
            foreach ($keranjang->itemKeranjangs as $item) {
                if ($item->produk->stok < $item->kuantitas) {
                    Log::warning('Stok tidak mencukupi pada saat checkout', [
                        'user_id' => Auth::id(),
                        'produk_id' => $item->produk_id,
                        'requested_quantity' => $item->kuantitas,
                        'available_stock' => $item->produk->stok,
                    ]);

                    return response()->json([
                        'error' => 'Stok untuk produk "' . $item->produk->nama_produk . '" tidak mencukupi. Silakan periksa kembali keranjang Anda.'
                    ], 422);
                }
            }

            // Gunakan Transaksi Database untuk memastikan integritas data
            $pesanan = DB::transaction(function () use ($pelanggan, $keranjang, $alamat) {
                // Hitung ulang total dari backend untuk keamanan
                $total_harga_produk = 0;
                foreach ($keranjang->itemKeranjangs as $item) {
                    $total_harga_produk += $item->produk->harga * $item->kuantitas;
                }
                $biaya_pengiriman = config('app.shipping_flat', 15000); // gunakan config supaya mudah diubah
                $total_keseluruhan = $total_harga_produk + $biaya_pengiriman;

                // 1. Buat record Pesanan (Order)
                $pesanan = Pesanan::create([
                    'pelanggan_id' => $pelanggan->id,
                    'alamat_pengiriman_id' => $alamat->id,
                    'kode_pesanan' => 'BTM-' . strtoupper(Str::random(8)),
                    'tanggal_pesanan' => now(),
                    'status_pesanan' => 'menunggu_pembayaran',
                    'total_harga_produk' => $total_harga_produk,
                    'biaya_pengiriman' => $biaya_pengiriman,
                    'total_keseluruhan' => $total_keseluruhan,
                ]);

                // 2. Pindahkan item dari keranjang ke detail pesanan & kurangi stok
                foreach ($keranjang->itemKeranjangs as $item) {
                    $pesanan->detailPesanans()->create([
                        'produk_id' => $item->produk_id,
                        'nama_produk_saat_pesan' => $item->produk->nama_produk,
                        'kuantitas' => $item->kuantitas,
                        'harga_produk_saat_pesan' => $item->produk->harga,
                        'subtotal_item' => $item->produk->harga * $item->kuantitas,
                    ]);
                    $item->produk->decrement('stok', $item->kuantitas);
                }

                // 3. Buat record Pembayaran awal
                $pesanan->pembayaran()->create([
                    'status_pembayaran' => 'pending',
                    'jumlah_dibayar' => $total_keseluruhan,
                    'metode_pembayaran' => 'menunggu',
                ]);

                // 4. Hapus keranjang setelah pesanan dibuat
                $keranjang->itemKeranjangs()->delete();
                $keranjang->delete();

                return $pesanan;
            });

            // Kirim email notifikasi pesanan dibuat
            Mail::queue(new OrderCreatedMail($pesanan));

            // Siapkan data untuk dikirim ke Midtrans
            // FIX: Gunakan $user yang sudah didefinisikan di atas
            $midtransPayload = [
                'transaction_details' => [
                    'order_id' => $pesanan->kode_pesanan,
                    'gross_amount' => (int) $pesanan->total_keseluruhan,
                ],
                'customer_details' => [
                    'first_name' => $user->name,
                    'email' => $user->email,
                    'phone' => $alamat->no_hp_penerima,
                ],
            ];

            // Debug: Log payload yang akan dikirim
            Log::info('Midtrans Payload:', $midtransPayload);
            Log::info('Midtrans Config:', [
                'server_key' => \Midtrans\Config::$serverKey ? 'SET' : 'NULL',
                'client_key' => \Midtrans\Config::$clientKey ? 'SET' : 'NULL',
                'is_production' => \Midtrans\Config::$isProduction,
            ]);

            // Dapatkan Snap Token dari Midtrans untuk menampilkan popup pembayaran
            $snapToken = \Midtrans\Snap::getSnapToken($midtransPayload);

            // Kirim token sebagai response JSON ke frontend
            return response()->json(['snap_token' => $snapToken]);
        } catch (\Exception $e) {
            // Log structured exception for server-side debugging (do not expose to clients)
            Log::error('Error dalam prosesPesanan', ['exception' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);

            // Return a generic message to the client to avoid leaking internals
            return response()->json([
                'error' => 'Terjadi kesalahan pada layanan pembayaran. Silakan coba lagi nanti atau hubungi customer service.'
            ], 500);
        }
    }

    /**
     * Menangani notifikasi pembayaran dari Midtrans (Webhook).
     * Melakukan validasi signature untuk memastikan notifikasi dari Midtrans yang authentic.
     */
    public function notificationHandler(Request $request, $notification = null)
    {
        // Jika notifikasi disuntikkan (mis. pada pengujian), gunakan itu
        if ($notification === null) {
            // Pertama: pastikan signature/key Midtrans valid saat membuat Notification
            try {
                $notification = new \Midtrans\Notification();
            } catch (\Exception $e) {
                Log::warning('Invalid Midtrans notification signature or misconfigured Midtrans keys', [
                    'message' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                    'timestamp' => now(),
                ]);

                // Signature invalid: beri 403 agar asal request dapat dideteksi
                return response()->json(['error' => 'Invalid notification signature'], 403);
            }
        }

        try {
            // Extract transaction details
            $transactionStatus = $notification->transaction_status;
            $orderId = $notification->order_id; // Ini adalah kode_pesanan kita
            $fraudStatus = $notification->fraud_status;
            $paymentType = $notification->payment_type ?? 'unknown';
            $transactionId = $notification->transaction_id ?? null;
            $grossAmount = (int) ($notification->gross_amount ?? 0);

            // Log notification diterima untuk debugging
            Log::info('Notifikasi Midtrans diterima', [
                'order_id' => $orderId,
                'transaction_status' => $transactionStatus,
                'fraud_status' => $fraudStatus,
                'payment_type' => $paymentType,
                'transaction_id' => $transactionId,
                'gross_amount' => $grossAmount,
                'timestamp' => now(),
            ]);

            /** @var \App\Models\Pesanan|null $pesanan */
            $pesanan = Pesanan::where('kode_pesanan', $orderId)->first();

            if (! $pesanan) {
                Log::warning('Notifikasi diterima untuk pesanan yang tidak ditemukan', [
                    'order_id' => $orderId,
                ]);
                // Return 200 OK to acknowledge receipt (no action possible)
                return response()->json(['message' => 'Pesanan tidak ditemukan'], 200);
            }

            // Proses perubahan status secara atomik
            DB::transaction(function () use ($pesanan, $notification, $transactionStatus, $fraudStatus, $paymentType, $transactionId, $grossAmount, $request, $orderId) {
                $pembayaran = $pesanan->pembayaran;

                // Idempotency: jika sudah sukses, skip
                if ($pembayaran && $pembayaran->status_pembayaran === 'sukses') {
                    Log::info('Duplikat notifikasi Midtrans diterima untuk pesanan yang sudah sukses, di-skip', ['order_id' => $orderId]);
                    return;
                }

                // Amount verification untuk menghindari modifikasi jumlah dari pihak ketiga
                if ($pembayaran && (int) $pembayaran->jumlah_dibayar !== $grossAmount) {
                    Log::warning('Amount mismatch pada notifikasi Midtrans', [
                        'order_id' => $orderId,
                        'expected' => $pembayaran->jumlah_dibayar,
                        'received' => $grossAmount,
                    ]);

                    // Lempar exception khusus untuk menandakan masalah amount sehingga dapat ditangani di luar transaksi
                    throw new \RuntimeException('amount_mismatch');
                }

                if ($transactionStatus === 'capture' || $transactionStatus === 'settlement') {
                    if ($fraudStatus === 'accept') {
                        $pesanan->status_pesanan = 'diproses';
                        if ($pembayaran) {
                            $pembayaran->status_pembayaran = 'sukses';
                            $pembayaran->tanggal_pembayaran = now();
                        }

                        // Kirim email konfirmasi pembayaran (dalam transaksi tidak menunggu)
                        Mail::queue(new PaymentConfirmedMail($pesanan));
                    }
                } elseif (in_array($transactionStatus, ['deny', 'expire', 'cancel'])) {
                    $pesanan->status_pesanan = 'dibatalkan';
                    if ($pembayaran) {
                        $pembayaran->status_pembayaran = 'gagal';
                    }
                    // Kembalikan stok produk yang dibatalkan
                    foreach ($pesanan->detailPesanans as $item) {
                        $item->produk->increment('stok', $item->kuantitas);
                    }
                }

                // Simpan info gateway dan metadata payload untuk audit
                if ($pembayaran) {
                    $pembayaran->metode_pembayaran = $paymentType;
                    if ($transactionId) {
                        $pembayaran->id_transaksi_gateway = $transactionId;
                    }
                    // Simpan seluruh payload notifikasi untuk keperluan audit/penyidikan
                    $pembayaran->detail_gateway = $request->all();
                    $pembayaran->save();

                    Log::info('Status pembayaran diperbarui', [
                        'order_id' => $orderId,
                        'payment_status' => $pembayaran->status_pembayaran,
                        'payment_method' => $pembayaran->metode_pembayaran,
                    ]);
                }

                // Simpan perubahan pada pesanan
                $pesanan->save();
            });

            Log::info('Notifikasi pesanan diproses berhasil', [
                'order_id' => $orderId,
                'order_status' => $pesanan->status_pesanan,
                'timestamp' => now(),
            ]);

            return response()->json(['message' => 'Notifikasi berhasil diproses.']);
        } catch (\RuntimeException $e) {
            // Tangani kasus khusus seperti amount mismatch
            if ($e->getMessage() === 'amount_mismatch') {
                return response()->json(['error' => 'Amount mismatch pada notifikasi'], 400);
            }

            Log::error('Error dalam notification handler: ' . $e->getMessage(), [
                'exception' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'timestamp' => now(),
            ]);

            // Kembalikan 500 agar Midtrans akan melakukan retry (idempotency sudah diterapkan)
            return response()->json(['error' => 'Terjadi kesalahan saat memproses notifikasi'], 500);
        } catch (\Exception $e) {
            Log::error('Unhandled exception in notification handler: ' . $e->getMessage(), [
                'exception' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'timestamp' => now(),
            ]);
            return response()->json(['error' => 'Terjadi kesalahan saat memproses notifikasi'], 500);
        }
    }

    /**
     * Menampilkan halaman sukses pembayaran dengan detail pesanan.
     *
     * @param string $kode Kode pesanan yang telah dibayar
     * @return \Illuminate\View\View
     */
    public function successPage($kode)
    {
        // Cari pesanan berdasarkan kode
        $pesanan = Pesanan::where('kode_pesanan', $kode)->first();

        // Jika pesanan tidak ditemukan atau bukan milik user yang login
        if (!$pesanan || $pesanan->pelanggan->user_id !== Auth::id()) {
            abort(404);
        }

        // Load relationships untuk tampilan yang lengkap
        $pesanan->load(['detailPesanans.produk', 'pembayaran', 'alamatPengiriman']);

        return view('pembayaran.sukses', [
            'pesanan' => $pesanan,
        ]);
    }
}
