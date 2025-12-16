<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\KategoriProdukController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\UlasanController;
use App\Http\Controllers\AlamatController;
use App\Http\Controllers\PembayaranController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- RUTE UTAMA & PUBLIK ---
Route::get('/', [HomeController::class, 'index'])->name('home');

// Redirect dashboard ke home
Route::redirect('/dashboard', '/')->name('dashboard');

// Rute Produk (Publik)
Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');
Route::get('/produk/{produk:slug}', [ProdukController::class, 'show'])->name('produk.show');
Route::get('/kategori/{kategoriProduk:slug}', [KategoriProdukController::class, 'show'])->name('kategori.show');


// --- RUTE YANG MEMERLUKAN LOGIN PENGGUNA ---
Route::middleware(['auth', 'verified'])->group(function () {

    // -- Profile --
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // -- Keranjang Belanja --
    Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang.index');
    Route::post('/keranjang/tambah', [KeranjangController::class, 'tambahKeKeranjang'])->name('keranjang.tambah');
    Route::patch('/keranjang/{itemKeranjang}', [KeranjangController::class, 'update'])->name('keranjang.update');
    Route::delete('/keranjang/{itemKeranjang}', [KeranjangController::class, 'destroy'])->name('keranjang.destroy');

    // -- Pesanan & Ulasan --
    Route::get('/pesanan', [PesananController::class, 'index'])->name('pesanan.index');
    Route::get('/pesanan/{pesanan}', [PesananController::class, 'show'])->name('pesanan.show');
    Route::post('/ulasan', [UlasanController::class, 'store'])->name('ulasan.store');

    // -- Manajemen Alamat --
    Route::get('/alamat', [AlamatController::class, 'index'])->name('alamat.index');
    Route::post('/alamat', [AlamatController::class, 'store'])->name('alamat.store');
    Route::delete('/alamat/{alamat}', [AlamatController::class, 'destroy'])->name('alamat.destroy');
    Route::patch('/alamat/{alamat}/set-utama', [AlamatController::class, 'setUtama'])->name('alamat.set-utama');

    // -- Checkout & Pembayaran --
    // [PERBAIKAN DI SINI] Mengubah name('checkout.index') menjadi name('pembayaran.checkout')
    Route::get('/checkout', [PembayaranController::class, 'checkout'])->name('pembayaran.checkout');

    // Menyesuaikan juga nama proses agar konsisten
    Route::post('/checkout/proses', [PembayaranController::class, 'prosesPesanan'])->name('pembayaran.proses');

    Route::get('/pesanan/sukses/{kode}', [PembayaranController::class, 'successPage'])->name('pembayaran.sukses');
});

// -- Webhook Midtrans --
Route::post('/midtrans/notification', [PembayaranController::class, 'notificationHandler'])->name('midtrans.notification');

require __DIR__ . '/auth.php';
