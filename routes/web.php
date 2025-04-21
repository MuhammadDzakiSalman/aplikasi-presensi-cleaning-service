<?php

use App\Models\Presensi;
use App\Http\Middleware\CheckRole;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IzinController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RiwayatIzinController;
use App\Http\Controllers\RiwayatPresensiController;

$router->aliasMiddleware('role', CheckRole::class);

Route::get('/login', function () {
    return view('auth.login');
});

Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/riwayat-izin', [RiwayatIzinController::class, 'index'])->name('riwayat.izin');

Route::middleware(['role:admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    Route::get('/izin', [IzinController::class, 'index'])->name('izin.index');

    Route::get('/presensi', [PresensiController::class, 'index'])->name('presensi.index');

    Route::post('/presensi', [PresensiController::class, 'updateJamKerja'])->name('jam-kerja.update');

    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');

    Route::resource('cleaning_service', UserController::class);
    
    Route::get('/download-pdf', [UserController::class, 'downloadPdf'])->name('cleaning_service.download_pdf');

    Route::get('/laporan/export-pdf', [LaporanController::class, 'exportPdf'])->name('laporan.export.pdf');

});

Route::middleware(['role:cleaning_service'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('user.home');
    Route::get('/izin-form', function () {
        return view('users.izin');
    })->name('user.izin-form');
    Route::post('/izin/store', [IzinController::class, 'store'])->name('izin.store');

    Route::get('/presensi/in', [PresensiController::class, 'presensiIn'])->name('presensi.in');
    Route::get('/presensi/out', [PresensiController::class, 'presensiOut'])->name('presensi.out');
    Route::post('/presensi/in', [PresensiController::class, 'presensiMasuk'])->name('presensi.in');
    Route::post('/presensi/out', [PresensiController::class, 'PresensiKeluar'])->name('presensi.out');

    Route::get('/riwayat-presensi', [RiwayatPresensiController::class, 'index'])->name('riwayat.presensi');
});

Route::get('/presensi/{id}/detail', [PresensiController::class, 'show'])->name('presensi.detail');

