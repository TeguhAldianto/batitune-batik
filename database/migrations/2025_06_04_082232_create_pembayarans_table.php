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
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pesanan_id')->unique()->constrained('pesanans')->onDelete('cascade');
            $table->string('metode_pembayaran')->default('menunggu');
            $table->enum('status_pembayaran', ['pending', 'sukses', 'gagal', 'kadaluarsa', 'refund'])->default('pending');
            $table->decimal('jumlah_dibayar', 12, 2);
            $table->timestamp('tanggal_pembayaran')->nullable();
            $table->string('bukti_pembayaran')->nullable();
            $table->string('id_transaksi_gateway')->nullable()->index();
            $table->json('detail_gateway')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};
