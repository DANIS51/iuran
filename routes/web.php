<?php

use App\Http\Controllers\KeuanganController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WargaController;
use App\Http\Controllers\IuranController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\OfficerController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ✅ Halaman utama aplikasi
Route::get('/', function () {
    return view('home');
});

// ✅ Route Auth (login & logout)
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ✅ =============================
// ✅ ADMIN ROUTE
// ✅ =============================
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {

    // Dashboard Admin
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
    Route::delete('/pembayaran/bulk-delete', [PembayaranController::class, 'bulkDelete'])->name('pembayaran.bulkDelete');
    Route::get('/pembayaran/{id}/edit', [PembayaranController::class, 'edit'])->name('pembayaran.edit');
    Route::put('/pembayaran/{id}', [PembayaranController::class, 'update'])->name('pembayaran.update');
    Route::delete('/pembayaran/{id}', [PembayaranController::class, 'destroy'])->name('pembayaran.destroy');

 Route::get('/keuangan', [KeuanganController::class, 'index'])->name('keuangan.index');
Route::get('/keuangan/create', [KeuanganController::class, 'create'])->name('keuangan.create');
Route::post('/keuangan', [KeuanganController::class, 'store'])->name('keuangan.store');
Route::delete('/keuangan/{id}', [KeuanganController::class, 'destroy'])->name('keuangan.destroy');


    // Data Officer
    Route::get('/officer', [OfficerController::class, 'index'])->name('officer.index');
    Route::get('/officer/create', [OfficerController::class, 'create'])->name('officer.create');
    Route::post('/officer/store', [OfficerController::class, 'store'])->name('officer.store');
    Route::get('/officer/{id}/edit', [OfficerController::class, 'edit'])->name('officer.edit');
    Route::put('/officer/{id}', [OfficerController::class, 'update'])->name('officer.update');
    Route::delete('/officer/{id}', [OfficerController::class, 'destroy'])->name('officer.destroy');
});

// ✅ =============================
// ✅ OFFICER ROUTE
// ✅ =============================
Route::prefix('officer')->middleware(['auth', 'role:officer'])->group(function () {
    Route::get('/dashboard', function () {
        return view('officer.dashboard');
    })->name('officer.dashboard');

    // Officer bisa mengelola pembayaran warga
    Route::get('/pembayaran', [PembayaranController::class, 'index'])->name('officer.pembayaran');
    Route::get('/pembayaran/create', [PembayaranController::class, 'create'])->name('officer.pembayaran.create');
    Route::post('/pembayaran/store', [PembayaranController::class, 'store'])->name('officer.pembayaran.store');
    Route::get('/pembayaran/{id}/edit', [PembayaranController::class, 'edit'])->name('officer.pembayaran.edit');
    Route::put('/pembayaran/{id}', [PembayaranController::class, 'update'])->name('officer.pembayaran.update');
    Route::delete('/pembayaran/{id}', [PembayaranController::class, 'destroy'])->name('officer.pembayaran.destroy');
    Route::delete('/pembayaran/bulk-delete', [PembayaranController::class, 'bulkDelete'])->name('officer.pembayaran.bulkDelete');

    // Officer bisa mengelola keuangan
    Route::get('/keuangan', [KeuanganController::class, 'index'])->name('officer.keuangan');
    Route::get('/keuangan/create', [KeuanganController::class, 'create'])->name('officer.keuangan.create');
    Route::post('/keuangan/store', [KeuanganController::class, 'store'])->name('officer.keuangan.store');
    Route::delete('/keuangan/{id}', [KeuanganController::class, 'destroy'])->name('officer.keuangan.destroy');
});
