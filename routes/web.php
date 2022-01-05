<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\{
    PerguruanTinggiController,
    ProgramStudiController,
    KurikulumController,
    MataKuliahController,
    BobotNilaiController,
    KelasKuliahController
};

use App\Http\Controllers\Akademika\{
    KRS\PesertaKelasKuliahController,
};

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::group(['middleware' => ['Role:admin'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('/perguruan_tinggi', [PerguruanTinggiController::class, 'index'])->name('perguruan_tinggi.index');
    Route::resource('/program_studi', ProgramStudiController::class)->except(['show']);;
    Route::get('/program_studi/data_index', [ProgramStudiController::class, 'data_index'])->name('program_studi.data_index');

    Route::resource('/kurikulum', KurikulumController::class)->except(['show']);;
    Route::get('/kurikulum/data_index', [KurikulumController::class, 'data_index'])->name('kurikulum.data_index');
    
    Route::resource('/mata_kuliah', MataKuliahController::class)->except(['show']);;
    Route::get('/mata_kuliah/data_index', [MataKuliahController::class, 'data_index'])->name('mata_kuliah.data_index');
    
    Route::resource('/bobot_nilai', BobotNilaiController::class)->except(['show']);
    Route::get('/bobot_nilai/data_index', [BobotNilaiController::class, 'data_index'])->name('bobot_nilai.data_index');

    Route::resource('/kelas_kuliah', KelasKuliahController::class)->except(['show']);
    Route::get('/kelas_kuliah/data_index', [KelasKuliahController::class, 'data_index'])->name('kelas_kuliah.data_index');

    Route::resource('/peserta_kelas_kuliah', PesertaKelasKuliahController::class)->except(['show']);
    Route::get('/peserta_kelas_kuliah/{kelas_kuliah}/anggota', [PesertaKelasKuliahController::class, 'anggota'])->name('peserta_kelas_kuliah.anggota');
    Route::get('/peserta_kelas_kuliah/data_index', [PesertaKelasKuliahController::class, 'data_index'])->name('peserta_kelas_kuliah.data_index');
});