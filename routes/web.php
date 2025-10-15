<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WargaController;
use App\Http\Controllers\IuranController;
use App\Http\Controllers\PembayaranController;

// ✅ Route utama (redirect ke admin)
Route::get('/', function () {
    return redirect('/admin');
});

// ✅ Semua route admin
Route::prefix('admin')->group(function () {
    // Dashboard
    Route::get('/', [WargaController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/dashboard', [WargaController::class, 'dashboard'])->name('admin.dashboard');

    // Data Warga
    Route::get('/warga', [WargaController::class, 'index'])->name('warga.index');
    Route::get('/warga/create', [WargaController::class, 'create'])->name('warga.create');
    Route::post('/warga/store', [WargaController::class, 'store'])->name('warga.store');
    Route::get('/warga/edit/{id}', [WargaController::class, 'edit'])->name('warga.edit');
    Route::put('/warga/{id}', [WargaController::class, 'update'])->name('warga.update');
    Route::delete('/warga/{id}', [WargaController::class, 'destroy'])->name('warga.destroy');

    // Data Iuran
    Route::get('/iuran', [IuranController::class, 'index'])->name('iuran.index');
    Route::get('/iuran/create', [IuranController::class, 'create'])->name('iuran.create');
    Route::post('/iuran/store', [IuranController::class, 'store'])->name('iuran.store');
    Route::get('/iuran/{id}/edit', [IuranController::class, 'edit'])->name('iuran.edit');
    Route::put('/iuran/{id}', [IuranController::class, 'update'])->name('iuran.update');
    Route::delete('/iuran/{id}', [IuranController::class, 'destroy'])->name('iuran.destroy');

    // Data Pembayaran
    Route::get('/pembayaran', [PembayaranController::class, 'index'])->name('pembayaran.index');
    Route::get('/pembayaran/create', [PembayaranController::class, 'create'])->name('pembayaran.create');
    Route::post('/pembayaran/store', [PembayaranController::class, 'store'])->name('pembayaran.store');
    Route::get('/pembayaran/{id}/edit', [PembayaranController::class, 'edit'])->name('pembayaran.edit');
    Route::put('/pembayaran/{id}', [PembayaranController::class, 'update'])->name('pembayaran.update');
    Route::delete('/pembayaran/{id}', [PembayaranController::class, 'destroy'])->name('pembayaran.destroy');
});
