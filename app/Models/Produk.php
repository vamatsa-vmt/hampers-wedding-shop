<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $fillable = [
        'KODE_PRODUK',
        'KODE_KATEGORI_PRODUK',
        'NAMA_PRODUK',
        'IMAGE_PRODUK',
        'DESKRIPSI',
        'HARGA',
        'STOK',
        'STATUS',
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriProduk::class, 'KODE_KATEGORI_PRODUK','id');
    }
    public function transaksi()
    {
        return $this->belongsToMany(Transaksi::class, 'transaksi', 'KODE_PRODUK', 'KODE_TRANSAKSI');
    }
}
