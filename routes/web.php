<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthController, DashboardController, KategoriProdukController, 
    ProdukController, CartController, TransaksiController
};

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Register web routes for your application.
|
*/

// Redirect root URL to login page
Route::redirect('/', '/pelanggan');
Route::get('/pelanggan', [ProdukController::class, 'publicIndex'])->name('pelanggan.index');

// Guest routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::match(['get', 'post'], '/register', [AuthController::class, 'register'])->name('register');
    Route::get('/verify-email/{id}', [AuthController::class, 'verifyEmail'])->name('verify.email');
});

// Authenticated user routes
Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Admin routes
    Route::prefix('admin')->middleware(['auth', 'role:Admin'])->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('admin.index');
        Route::get('/auth/profile', [AuthController::class, 'profile'])->name('auth.profile');
        Route::post('/auth/profile', [AuthController::class, 'update'])->name('auth.profile.update');
        Route::resource('kategoriproduk', KategoriProdukController::class);
        Route::resource('produk', ProdukController::class);
        Route::resource('pesanan', TransaksiController::class);
        Route::prefix('pesanan')->group(function () {
            Route::post('/{transaksi}/update', [TransaksiController::class, 'updateStatus'])->name('admin.pesanan.update');
            Route::get('/{kodeTransaksi}', [TransaksiController::class, 'showDetailAdmin'])->name('pesanan.detail');
            Route::get('/{kodeTransaksi}/cetak', [TransaksiController::class, 'cetakNota'])->name('pesanan.cetak');
        });
        Route::get('/laporan', [TransaksiController::class, 'laporan'])->name('admin.pesanan.laporan');
        Route::get('/laporan/cetak', [TransaksiController::class, 'printLaporan'])->name('admin.pesanan.laporan.cetak');
        Route::get('/oesanan/{kodeTransaksi}', [TransaksiController::class, 'showDetailAdmin'])->name('pesanan.detail');
        Route::get('/pesanan/{kodeTransaksi}/cetak', [TransaksiController::class, 'cetakNota'])->name('pesanan.cetak');
        Route::prefix('pesanan')->group(function () {
        });
    }); 

    // Customer routes
    Route::prefix('pelanggan')->middleware(['auth', 'role:Pelanggan'])->group(function () {
        Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
        Route::post('/profile', [AuthController::class, 'update'])->name('profile.update');
        Route::prefix('cart')->group(function () {
            Route::get('/', [CartController::class, 'index'])->name('pelanggan.cart.index');
            Route::post('/', [CartController::class, 'store'])->name('pelanggan.cart.store');
            Route::delete('/{id}', [CartController::class, 'destroy'])->name('pelanggan.cart.destroy');
            Route::post('/clear', [CartController::class, 'clear'])->name('pelanggan.cart.clear');
        });
        Route::prefix('transaksi')->group(function () {
            Route::get('/', [TransaksiController::class, 'create'])->name('pelanggan.transaksi.create');
            Route::post('/', [TransaksiController::class, 'store'])->name('pelanggan.transaksi.store');
        });
        Route::get('/riwayat', [TransaksiController::class, 'riwayat'])->name('pelanggan.riwayat');
        Route::get('/riwayat/{kode_transaksi}', [TransaksiController::class, 'showDetailPelanggan'])->name('pelanggan.detail');
        Route::get('/{kodeTransaksi}/cetak', [TransaksiController::class, 'cetakNotaPelanggan'])->name('pelanggan.riwayat.cetak');
    });

    Route::get('/produkDetail/{id}', [ProdukController::class, 'produkDetail'])->name('produk.detail');
});