<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Dosen\{
    BiodataController as BiodataDosenController,
    KRSController as VerifikasiKRSController,
    VervalKRSController,
    JadwalMengajarController,
    NilaiController,
    JurnalPerkuliahanController,
    MateriPerkuliahanController,
    PenelitianController,
    PengabdianController,
    PublikasiController,
    DashboardController
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
    ['middleware' => ['Role:dosen'], 'as' => 'dosen.'],
    function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name(
            'dashboard'
        );
        Route::get('/biodata', [BiodataDosenController::class, 'index'])->name(
            'biodata.index'
        );
        Route::put('/biodata/update', [
            BiodataDosenController::class,
            'update',
        ])->name('biodata.update');

        Route::get('/verval_krs', [VervalKRSController::class, 'index'])->name(
            'verval_krs.index'
        );
        Route::get('/verval_krs/data_index', [
            VervalKRSController::class,
            'data_index',
        ])->name('verval_krs.data_index');

        Route::get('/krs/{id_mahasiswa}/{id_semester}', [
            VerifikasiKRSController::class,
            'index',
        ])->name('krs.index');
        Route::get('/krs/data_index/{id_mahasiswa}/{id_semester}', [
            VerifikasiKRSController::class,
            'data_index',
        ])->name('krs.data_index');
        Route::post('/update_krs/{id_mahasiswa}/{id_semester}/setujui', [
            VerifikasiKRSController::class,
            'update_status',
        ])->name('krs.update_status');

        Route::get('/jadwal_mengajar', [
            JadwalMengajarController::class, 
            'index'
        ])->name('jadwal_mengajar.index');
        Route::get('/jadwal_mengajar/data_index', [
            JadwalMengajarController::class, 
            'data_index'
        ])->name('jadwal_mengajar.data_index');
        Route::get('/jadwal_mengajar/{id_jadwal}/daftar_peserta', [
            JadwalMengajarController::class, 
            'daftar_peserta'
        ])->name('jadwal_mengajar.daftar_peserta');
        Route::put('/jadwal_mengajar/{id}', [
            JadwalMengajarController::class, 
            'update'
        ])->name('jadwal_mengajar.update');
    
        Route::resource('/jurnal_perkuliahan', JurnalPerkuliahanController::class)->except([
            'show',
            'index',
            'create',
        ]);
        Route::get('/jurnal_perkuliahan/{id_kelas_kuliah}/create', [
            JurnalPerkuliahanController::class, 
            'create'
        ])->name('jurnal_perkuliahan.create');
        Route::get('/jurnal_perkuliahan', [
            JurnalPerkuliahanController::class, 
            'index'
        ])->name('jurnal_perkuliahan.index');
        Route::get('/jurnal_perkuliahan/data_index', [
            JurnalPerkuliahanController::class, 
            'data_index'
        ])->name('jurnal_perkuliahan.data_index');
        Route::get('/jurnal_perkuliahan/{id_kelas_kuliah}/jurnal', [
            JurnalPerkuliahanController::class, 
            'jurnal_index'
        ])->name('jurnal_perkuliahan.jurnal_index');
        Route::get('/jurnal_perkuliahan/{id_kelas_kuliah}/jurnal_data_index', [
            JurnalPerkuliahanController::class, 
            'jurnal_data_index'
        ])->name('jurnal_perkuliahan.jurnal_data_index');
        Route::get('/jurnal_perkuliahan/{id_kelas_kuliah}/mahasiswa_data_index/{id_jurnal?}', [
            JurnalPerkuliahanController::class, 
            'list_mahasiswa'
        ])->name('jurnal_perkuliahan.mahasiswa_data_index');
        Route::get('/jurnal_perkuliahan/{id_kelas_kuliah}/cetak', [
            JurnalPerkuliahanController::class, 
            'cetak'
        ])->name('jurnal_perkuliahan.cetak');

        Route::get('/penelitian/data_index', [
            PenelitianController::class, 
            'data_index'
        ])->name('penelitian.data_index');
        Route::resource('/penelitian', PenelitianController::class)
            ->except(['show', 'create', 'edit']);

        Route::get('/pengabdian/data_index', [
            PengabdianController::class, 
            'data_index'
        ])->name('pengabdian.data_index');
        Route::resource('/pengabdian', PengabdianController::class)
            ->except(['show', 'create', 'edit']);

        Route::get('/publikasi/data_index', [
            PublikasiController::class, 
            'data_index'
        ])->name('publikasi.data_index');
        Route::resource('/publikasi', PublikasiController::class)
            ->except(['show', 'create', 'edit']);

        Route::get('/materi_perkuliahan/{materi_perkuliahan}/data_index', [
            MateriPerkuliahanController::class, 
            'data_index'
        ])->name('{materi_perkuliahan}.data_index');
        Route::resource('/materi_perkuliahan/{materi_perkuliahan}', MateriPerkuliahanController::class)
            ->except(['show', 'create', 'edit', 'update', 'destroy']);
        Route::put('/materi_perkuliahan/{materi_perkuliahan}/{id}', [
            MateriPerkuliahanController::class, 
            'update'
        ])->name('{materi_perkuliahan}.update');
        Route::delete('/materi_perkuliahan/{materi_perkuliahan}/{id}', [
            MateriPerkuliahanController::class, 
            'destroy'
        ])->name('{materi_perkuliahan}.destroy');


        // Penilaian
        Route::get('/pengisian_nilai', [NilaiController::class, 'index'])->name('pengisian_nilai.index');
        Route::get('/pengisian_nilai/data_index', [NilaiController::class, 'data_index'])->name('pengisian_nilai.data_index');
        Route::get('/pengisian_nilai/{id_kelas_kuliah}/form_nilai', [NilaiController::class, 'form_nilai'])->name('pengisian_nilai.form_nilai');
        Route::post('/pengisian_nilai/store_nilai', [NilaiController::class, 'store_nilai'])->name('pengisian_nilai.store_nilai');
    }
);