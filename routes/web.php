<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\WajibPajakController;
use App\Http\Controllers\KendaraanController;
use App\Http\Controllers\PembayaranPajakController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\WaLogController;

// =========================
// AUTH
// =========================
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.process');
});

Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');


// =========================
// DASHBOARD — semua role
// =========================
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});


// =========================
// ADMIN ONLY
// =========================
Route::middleware(['auth', 'role:admin'])->group(function () {

    // Manajemen Anggota
    Route::prefix('anggota')->group(function () {
        Route::get('/', [AnggotaController::class, 'index'])->name('anggota');
        Route::get('/create', [AnggotaController::class, 'create'])->name('anggota.create');
        Route::post('/store', [AnggotaController::class, 'store'])->name('anggota.store');
        Route::get('/{user}/edit', [AnggotaController::class, 'edit'])->name('anggota.edit');
        Route::put('/{user}', [AnggotaController::class, 'update'])->name('anggota.update');
        Route::delete('/{user}', [AnggotaController::class, 'destroy'])->name('anggota.destroy');
    });
});


// =========================
// PETUGAS (Admin juga dapat)
// Akses: Wajib Pajak, Kendaraan, Pembayaran
// =========================
Route::middleware(['auth', 'role:admin,petugas'])->group(function () {

    // Wajib Pajak
    Route::prefix('wajib-pajak')->name('wajib.pajak')->group(function () {
        Route::get('/', [WajibPajakController::class, 'index'])->name('');
        Route::get('/create', [WajibPajakController::class, 'create'])->name('.create');
        Route::post('/', [WajibPajakController::class, 'store'])->name('.store');
        Route::get('/{id}', [WajibPajakController::class, 'show'])->name('.show');
        Route::get('/{id}/edit', [WajibPajakController::class, 'edit'])->name('.edit');
        Route::put('/{id}', [WajibPajakController::class, 'update'])->name('.update');
        Route::delete('/{id}', [WajibPajakController::class, 'destroy'])->name('.destroy');
        Route::get('/export/pdf', [WajibPajakController::class, 'exportPdf'])->name('.export.pdf');

        Route::get('/notifikasi/{id}', [WajibPajakController::class, 'notifikasiWa'])->name('.notifikasi');
        Route::post('/notif-pajak/kirim/{id}', [WajibPajakController::class, 'kirim'])->name('.notifikasi.kirim');

        Route::get('/kendaraan/{kendaraanId}/detail', [WajibPajakController::class, 'detailKendaraan'])->name('.kendaraan.detail');
        Route::get('/kendaraan/{kendaraanId}/pajak', [WajibPajakController::class, 'detailPajak'])->name('.kendaraan.pajak');
    });

    // Kendaraan
    Route::prefix('kendaraan')->group(function () {
        Route::get('/', [KendaraanController::class, 'index'])->name('kendaraan');
        Route::get('/pdf', [KendaraanController::class, 'exportPdf'])->name('kendaraan.pdf');
    });

    // Pembayaran Pajak
    Route::prefix('pembayaran')->name('pembayaran')->group(function () {
        Route::get('/', [PembayaranPajakController::class, 'index'])->name('');
        Route::get('/create', [PembayaranPajakController::class, 'create'])->name('.create');
        Route::get('/load-detail/{id}', [PembayaranPajakController::class, 'loadDetail'])->name('.loadDetail');
        Route::post('/store', [PembayaranPajakController::class, 'store'])->name('.store');
        Route::get('/{id}', [PembayaranPajakController::class, 'edit'])->name('.edit');
        Route::put('/update/{id}', [PembayaranPajakController::class, 'update'])->name('.update');
        Route::delete('/{id}', [PembayaranPajakController::class, 'destroy'])->name('.destroy');
    });
});


// =========================
// PIMPINAN (Admin juga dapat)
// Akses: Laporan, Log Pesan
// =========================
Route::middleware(['auth', 'role:admin,pimpinan,petugas'])->group(function () {
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan');

    // Log Pesan
    Route::get('/log-pesan', [WaLogController::class, 'index'])->name('log.pesan');
    Route::get('/log-pesan/export/pdf', [WaLogController::class, 'exportPdf'])->name('log.pesan.export.pdf');
});
