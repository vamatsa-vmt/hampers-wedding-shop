<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriProduk extends Model
{
    use HasFactory;

    protected $fillable = [
        'KODE_KATEGORI_PRODUK',
        'NAMA_KATEGORI_PRODUK',
        'IMAGE_KATEGORI_PRODUK',
    ];
    
    public function produks()
    {
        return $this->hasMany(Produk::class, 'KODE_KATEGORI_PRODUK', 'id');
    }
}
