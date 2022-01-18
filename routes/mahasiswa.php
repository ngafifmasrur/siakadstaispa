<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Mahasiswa\{
    DashboardController,
    BiodataController, 
    KRSController
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
    }
);