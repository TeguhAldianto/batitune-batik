<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pesanans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pelanggan_id')->constrained('pelanggans')->onDelete('cascade');
            $table->foreignId('alamat_pengiriman_id')->nullable()->constrained('alamats')->onDelete('set null'); // Jika alamat dihapus, pesanan tetap ada
            $table->string('kode_pesanan')->unique();
            $table->timestamp('tanggal_pesanan')->useCurrent();
            $table->enum('status_pesanan', ['menunggu_pembayaran', 'diproses', 'dikirim', 'selesai', 'dibatalkan'])->default('menunggu_pembayaran');
            $table->decimal('total_harga_produk', 12, 2);
            $table->decimal('biaya_pengiriman', 12, 2)->default(0);
            $table->decimal('diskon', 12, 2)->default(0);
            $table->decimal('total_keseluruhan', 12, 2); // total_harga_produk + biaya_pengiriman - diskon
            $table->text('catatan_pelanggan')->nullable();
            $table->string('jasa_pengiriman')->nullable();
            $table->string('no_resi_pengiriman')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanans');
    }
};
