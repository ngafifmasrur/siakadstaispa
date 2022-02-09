<?php

use Illuminate\Support\Facades\Route;

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

        Route::resource('/krs', KRSController::class)->except([
            'show',
            'index',
        ]);
        Route::get('/krs/{tahun_ajaran}', [
            KRSController::class,
            'index',
        ])->name('krs.index');
        Route::get('/krs/data_index/{tahun_ajaran}', [
            KRSController::class,
            'data_index',
        ])->name('krs.data_index');
        Route::post('/krs/ajukan/{tahun_ajaran}', [
            KRSController::class,
            'ajukan',
        ])->name('krs.ajukan');

        Route::get('prestasi_mahasiswa/data_index', [PrestasiMahasiswaController::class, 'data_index'])->name('prestasi_mahasiswa.data_index');
        Route::resource('prestasi_mahasiswa', PrestasiMahasiswaController::class);

        Route::get('aktivitas_perkuliahan/data_index', [AktivitasPerkuliahanController::class, 'data_index'])->name('aktivitas_perkuliahan.data_index');
        Route::resource('aktivitas_perkuliahan', AktivitasPerkuliahanController::class);

        Route::get('histori_pendidikan/data_index', [HistoriPendidikanController::class, 'data_index'])->name('histori_pendidikan.data_index');
        Route::resource('histori_pendidikan', HistoriPendidikanController::class);

        Route::get('histori_nilai/data_index', [HistoriNilaiController::class, 'data_index'])->name('histori_nilai.data_index');
        Route::resource('histori_nilai', HistoriNilaiController::class);

        Route::get('transkrip/data_index', [TranskripController::class, 'data_index'])->name('transkrip.data_index');
        Route::resource('transkrip', TranskripController::class);
    }
);