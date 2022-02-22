<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\Mahasiswa\{
    DashboardController,
    BiodataController,
    KRSController,
    PrestasiMahasiswaController,
    AktivitasPerkuliahanController,
    HistoriPendidikanController,
    HistoriNilaiController,
    TranskripController
};

/*
|--------------------------------------------------------------------------
| Dosen Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::group(
    [
        'middleware' => ['Role:mahasiswa'],
        'as' => 'mahasiswa.',
    ],
    function () {
        Route::get('/', fn () => redirect()->route('mahasiswa.dashboard'));
        Route::get('/dashboard', [DashboardController::class, 'index'])->name(
            'dashboard'
        );
        Route::get('/biodata', [BiodataController::class, 'index'])->name(
            'biodata.index'
        );
        Route::put('/biodata/update', [
            BiodataController::class,
            'update',
        ])->name('biodata.update');

        Route::get('/krs/data_index', [KRSController::class,'data_index',])->name('krs.data_index');
        Route::get('/krs', [ KRSController::class,'index',])->name('krs.index');
        Route::get('/krs/create', [ KRSController::class,'create',])->name('krs.create');
        Route::delete('/krs/{id_kelas_kuliah}/{id_registrasi_mahasiswa}', [KRSController::class,'destroy',])->name('krs.destroy');
        Route::post('/krs', [ KRSController::class,'store',])->name('krs.store');
        Route::get('/krs/list_kelas_kuliah', [KRSController::class,'list_kelas_kuliah',])->name('krs.list_kelas_kuliah');
        Route::post('krs/cetak', [KRSController::class, 'cetak'])->name('krs.cetak');
        Route::post('krs/ajukan/{id}', [KRSController::class, 'ajukan'])->name('krs.ajukan');

        Route::get('prestasi_mahasiswa/data_index', [PrestasiMahasiswaController::class, 'data_index'])->name('prestasi_mahasiswa.data_index');
        Route::resource('prestasi_mahasiswa', PrestasiMahasiswaController::class);

        Route::get('aktivitas_perkuliahan/data_index', [AktivitasPerkuliahanController::class, 'data_index'])->name('aktivitas_perkuliahan.data_index');
        Route::resource('aktivitas_perkuliahan', AktivitasPerkuliahanController::class);

        Route::get('histori_pendidikan/data_index', [HistoriPendidikanController::class, 'data_index'])->name('histori_pendidikan.data_index');
        Route::resource('histori_pendidikan', HistoriPendidikanController::class);

        Route::get('histori_nilai/data_index', [HistoriNilaiController::class, 'data_index'])->name('histori_nilai.data_index');
        Route::resource('histori_nilai', HistoriNilaiController::class);
        Route::post('histori_nilai/cetak', [HistoriNilaiController::class, 'cetak'])->name('histori_nilai.cetak');

        Route::get('transkrip/data_index', [TranskripController::class, 'data_index'])->name('transkrip.data_index');
        Route::resource('transkrip', TranskripController::class);
        Route::post('transkrip/cetak', [TranskripController::class, 'cetak'])->name('transkrip.cetak');

        // Pengaturan
        Route::get('/pengaturan_akun', [MainController::class, 'pengaturan_akun'])->name('pengaturan_akun');
        Route::post('/pengaturan_akun', [MainController::class, 'ganti_password'])->name('ganti_password');
    }
);