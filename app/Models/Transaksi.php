<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'KODE_TRANSAKSI',
        'id_user',
        'KODE_PRODUK',
        'DESKRIPSI_BUNGKUS',
        'IMAGE_BUNGKUS',
        'WAKTU_KIRIM',
        'IMAGE_BUKTI_TRANSAKSI',
        'STATUS',
        'alasan_ditolak',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'KODE_PRODUK', 'KODE_PRODUK');
    }
}
