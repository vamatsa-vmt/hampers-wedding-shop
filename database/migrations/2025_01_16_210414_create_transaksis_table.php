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
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->string('KODE_TRANSAKSI');
            $table->unsignedBigInteger('id_user');
            $table->string('KODE_PRODUK');
            $table->integer('JUMLAH');
            $table->text('DESKRIPSI_BUNGKUS')->nullable();
            $table->string('IMAGE_BUNGKUS')->nullable();
            $table->datetime('WAKTU_KIRIM');
            $table->string('IMAGE_BUKTI_TRANSAKSI');
            $table->enum('STATUS', ['menunggu konfirmasi', 'pesanan ditolak', 'dikemas', 'dikirim', 'selesai'])->default('menunggu konfirmasi');
            $table->timestamps();

            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
