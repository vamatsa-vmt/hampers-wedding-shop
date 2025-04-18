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
            $table->string('KODE_PRODUK')->unique();
            $table->foreignId('KODE_KATEGORI_PRODUK')->constrained('kategori_produks')->onDelete('cascade');
            $table->string('NAMA_PRODUK');
            $table->string('IMAGE_PRODUK');
            $table->text('DESKRIPSI');
            $table->integer('HARGA');
            $table->integer('STOK');
            $table->enum('STATUS', ['tersedia', 'habis']);
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
