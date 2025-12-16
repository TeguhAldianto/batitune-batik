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
        Schema::create('ulasans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pelanggan_id')->constrained('pelanggans')->onDelete('cascade');
            $table->foreignId('produk_id')->constrained('produks')->onDelete('cascade');
            $table->foreignId('pesanan_id')->nullable()->constrained('pesanans')->onDelete('set null');
            $table->integer('rating'); // 1-5
            $table->text('komentar')->nullable();
            $table->boolean('is_approved')->default(true); 
            $table->timestamps();
            
            $table->unique(['pelanggan_id', 'produk_id', 'pesanan_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ulasans');
    }
};
