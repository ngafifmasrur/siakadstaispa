<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\Bendahara\{
    DashboardController,
    PresensiDosenController,
    PresensiMahasiswaController
};

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(
    ['middleware' => ['Role:bendahara', 'checkfeeder'], 'as' => 'bendahara.'],
    function () {

        // Dashboard
        Route::get('/', fn () => redirect()->route('bendahara.dashboard'));
        Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('checkfeeder')->name('dashboard');

        // Pengaturan
        Route::get('/pengaturan_akun', [MainController::class, 'pengaturan_akun'])->name('pengaturan_akun');
        Route::post('/pengaturan_akun', [MainController::class, 'ganti_password'])->name('ganti_password');

        Route::get('/presensi_mahasiswa', [PresensiMahasiswaController::class, 'index'])->name('presensi_mahasiswa.index');
        Route::get('/presensi_mahasiswa/data_index', [PresensiMahasiswaController::class, 'data_index'])->name('presensi_mahasiswa.data_index');
        Route::get('/presensi_mahasiswa/{id_mahasiswa}/cetak_presensi', [PresensiMahasiswaController::class, 'cetak'])->name('presensi_mahasiswa.cetak');

        Route::get('/presensi_dosen', [PresensiDosenController::class, 'index'])->name('presensi_dosen.index');
        Route::get('/presensi_dosen/data_index', [PresensiDosenController::class, 'data_index'])->name('presensi_dosen.data_index');
        Route::get('/presensi_dosen/{id_dosen}/cetak_presensi', [PresensiDosenController::class, 'cetak'])->name('presensi_dosen.cetak');
    }
);
