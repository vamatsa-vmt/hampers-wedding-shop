<?php

namespace App\Http\Controllers;

use App\Models\KategoriProduk;
use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index() {
        $jumlah_data_admin = User::where('role', 'Admin')->count();
        $jumlah_data_pelanggan = User::where('role', 'Pelanggan')->count();
        $jumlah_data_kategori = KategoriProduk::count();
        $jumlah_data_produk = Produk::count();
        $jumlah_data_transaki = Transaksi::count();
        $total_omset = Transaksi::whereNotIn('STATUS', ['menunggu konfirmasi', 'pesanan ditolak'])->get()->sum(function ($transaksi) {
        return $transaksi->JUMLAH * $transaksi->produk->HARGA;
    });
    
        return view('admin.index', compact(
            'jumlah_data_admin',
            'jumlah_data_pelanggan',
            'jumlah_data_kategori',
            'jumlah_data_produk',
            'jumlah_data_transaki',
            'total_omset'
        ));
    }
}
