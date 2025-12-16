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
        Schema::create('produks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_produk_id')->constrained('kategori_produks')->onDelete('cascade');
            $table->string('nama_produk');
            $table->string('slug')->unique();
            $table->text('deskripsi');
            $table->decimal('harga', 12, 2);
            $table->unsignedInteger('stok');
            $table->string('gambar_produk')->nullable();
            $table->string('motif_batik')->nullable();
            $table->string('jenis_kain')->nullable();
            $table->string('ukuran')->nullable();
            $table->string('warna_dominan')->nullable();
            $table->unsignedInteger('berat_gram')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produks');
    }
};
