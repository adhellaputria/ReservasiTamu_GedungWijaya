<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReservasiController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RuanganController;
use App\Http\Controllers\AdminOpdController;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/reservasi', [ReservasiController::class, 'form'])->name('reservasi.form');
Route::post('/reservasi', [ReservasiController::class, 'store'])->name('reservasi.store');
Route::get('/reservasi/sukses/{kode}', [ReservasiController::class, 'sukses'])->name('reservasi.sukses');

Route::get('/cek-status', [ReservasiController::class, 'cekForm'])->name('cek.form');
Route::post('/cek-status', [ReservasiController::class, 'cekStatus'])->name('cek.status');


/*
|--------------------------------------------------------------------------
| ADMIN AUTH (NO MIDDLEWARE)
|--------------------------------------------------------------------------
*/

Route::get('/admin/login', [AdminController::class, 'loginForm'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login.post');
Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');


/*
|--------------------------------------------------------------------------
| ADMIN PROTECTED ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware('admin.auth')
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // ================= DASHBOARD =================
        Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

        // ================= SUPERADMIN ONLY =================
        Route::middleware('admin.role:admin_utama')->group(function () {

            // Kelola Ruangan / OPD
            Route::resource('ruangan', RuanganController::class);

            // Kelola Admin OPD
            Route::resource('opd-admin', AdminOpdController::class);
        });

        // ================= ADMIN OPD ONLY =================
        Route::middleware('admin.role:admin_opd')->group(function () {

            // Approve / Reject Reservasi
            Route::post('/reservasi/{id}/setujui', [AdminController::class, 'setujui'])
                ->name('reservasi.setujui');

            Route::post('/reservasi/{id}/tolak', [AdminController::class, 'tolak'])
                ->name('reservasi.tolak');

            // Verifikasi Kehadiran
            Route::get('/verifikasi', [AdminController::class, 'verifikasiIndex'])
                ->name('verifikasi.index');

            Route::post('/verifikasi/{id}/hadir', [AdminController::class, 'markHadir'])
                ->name('verifikasi.hadir');

        });

        // ================= SHARED (Superadmin & Admin OPD) =================

        // View Reservasi
        Route::get('/reservasi', [AdminController::class, 'reservasiIndex'])
            ->name('reservasi.index');

        Route::get('/reservasi/{id}', [AdminController::class, 'reservasiDetail'])
            ->name('reservasi.detail');

        Route::get('/reservasi/{id}/dokumen', [AdminController::class, 'bukaDokumen'])
            ->name('reservasi.dokumen');

        // Laporan
        Route::get('/laporan', [AdminController::class, 'laporan'])
            ->name('laporan');

        Route::get('/laporan/cetak', [AdminController::class, 'laporanCetak'])
            ->name('laporan.cetak');

    

});