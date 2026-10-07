<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\StokBahanController;
use App\Http\Controllers\OwnerMenuController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LaporanKeuanganController;

// ── Auth ──
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Redirect root ke halaman menu pelanggan
Route::get('/', [MenuController::class, 'index']);

Route::get('/menu', [MenuController::class, 'index']);

Route::get('/detail-menu/{id_menu}', [MenuController::class, 'detail']);

Route::get('/keranjang', [MenuController::class, 'keranjang']);

Route::get('/pembayaran', [MenuController::class, 'pembayaran']);


Route::post('/api/pembayaran/checkout', [PaymentController::class, 'processCheckout']);
Route::get('/api/pembayaran/status/{reference}', [PaymentController::class, 'checkStatus']);
Route::get('/menunggu-kasir', [PaymentController::class, 'menungguKasir']);
Route::get('/menunggu-qris', [PaymentController::class, 'menungguQris']);
Route::get('/api/pesanan/status/{id}', [PaymentController::class, 'checkLocalStatus']);
Route::post('/api/duitku/callback/', [PaymentController::class, 'callback']);

// Kasir
Route::middleware(['role:kasir'])->group(function () {
    Route::get('/kasir/antrian', [KasirController::class, 'antrian']);
    Route::get('/kasir/detail/{id}', [KasirController::class, 'detail']);
    Route::post('/kasir/detail/{id}/selesai', [KasirController::class, 'selesai']);
    Route::post('/kasir/detail/{id}/lunas', [KasirController::class, 'lunas']);
    Route::post('/kasir/detail/{id}/unlunas', [KasirController::class, 'unlunas']);
    Route::get('/kasir/detail/{id}/cetak', [KasirController::class, 'cetak']);
    Route::delete('/kasir/detail/{id}/hapus', [KasirController::class, 'hapus']);
    Route::get('/kasir/riwayat', [KasirController::class, 'riwayat']);
    Route::get('/kasir/riwayat/detail/{id}', [KasirController::class, 'detailRiwayat']);
});

// Owner
Route::middleware(['role:owner,manajer,admin'])->group(function () {
    Route::get('/owner/bahan', [StokBahanController::class, 'index']);
    Route::post('/owner/bahan', [StokBahanController::class, 'store']);
    Route::put('/owner/bahan/{id}', [StokBahanController::class, 'update']);
    Route::delete('/owner/bahan/{id}', [StokBahanController::class, 'destroy']);

    Route::get('/owner/menu', [OwnerMenuController::class, 'index']);
    Route::get('/owner/menu/create', [OwnerMenuController::class, 'create']);
    Route::post('/owner/menu', [OwnerMenuController::class, 'store']);
    Route::get('/owner/menu/{id}/edit', [OwnerMenuController::class, 'edit']);
    Route::post('/owner/menu/{id}/update', [OwnerMenuController::class, 'update']);
    Route::delete('/owner/menu/{id}', [OwnerMenuController::class, 'destroy']);

    Route::get('/owner/laporan', [LaporanKeuanganController::class, 'index']);
});

