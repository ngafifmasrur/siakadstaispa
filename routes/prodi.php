<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminProdi\{
    DashboardController,
    KurikulumController,
    MataKuliahController,
    KelasKuliahController,
    RuangKelasController,
    JadwalController,
    SemesterMahasiswaController,
    MataKuliahAktifController,
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
    ['middleware' => ['Role:admin_prodi'], 'as' => 'admin_prodi.'],
    function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name(
            'dashboard'
        );
        Route::resource(
            '/program_studi',
            ProgramStudiController::class
        )->except(['show']);
        Route::get('/program_studi/data_index', [
            ProgramStudiController::class,
            'data_index',
        ])->name('program_studi.data_index');

        Route::resource('/kurikulum', KurikulumController::class)->except([
            'show',
        ]);
        Route::get('/kurikulum/data_index', [
            KurikulumController::class,
            'data_index',
        ])->name('kurikulum.data_index');

        Route::resource('/mata_kuliah', MataKuliahController::class)->except([
            'show',
        ]);
        Route::get('/mata_kuliah/data_index', [
            MataKuliahController::class,
            'data_index',
        ])->name('mata_kuliah.data_index');

        Route::resource(
            '/kurikulum_prodi',
            MataKuliahAktifController::class
        )->except(['show']);
        Route::get('/kurikulum_prodi/data_index/{tahun_ajaran?}', [
            MataKuliahAktifController::class,
            'data_index',
        ])->name('kurikulum_prodi.data_index');

        Route::resource('/kelas_kuliah', KelasKuliahController::class)->except([
            'show',
        ]);
        Route::get('/kelas_kuliah/data_index', [
            KelasKuliahController::class,
            'data_index',
        ])->name('kelas_kuliah.data_index');

        Route::resource('/ruang_kelas', RuangKelasController::class)->except([
            'show',
        ]);

        Route::resource('/jadwal', JadwalController::class)->except(['show']);
        Route::get('/jadwal/data_index', [
            JadwalController::class,
            'data_index',
        ])->name('jadwal.data_index');

        Route::resource(
            '/semester_mahasiswa',
            SemesterMahasiswaController::class
        )->except(['show']);
        Route::get('/semester_mahasiswa/data_index', [
            SemesterMahasiswaController::class,
            'data_index',
        ])->name('semester_mahasiswa.data_index');
        Route::get('/semester_mahasiswa/mahasiswa_data_index', [
            SemesterMahasiswaController::class,
            'mahasiswa_data_index',
        ])->name('semester_mahasiswa.mahasiswa_data_index');
        Route::post('/semester_mahasiswa/generate', [
            SemesterMahasiswaController::class,
            'generate',
        ])->name('semester_mahasiswa.generate');
    }
);