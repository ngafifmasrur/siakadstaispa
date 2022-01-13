<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\{
    PerguruanTinggiController,
    ProgramStudiController,
    KurikulumController,
    MataKuliahController,
    MataKuliahAktifController,
    BobotNilaiController,
    DosenController,
    MahasiswaController,
    KelasKuliahController,
    RiwayatPendidikanMHSController,
    RuangKelasController,
    JadwalController,
    SemesterController
};

use App\Http\Controllers\Mahasiswa\{
    BiodataController,
    KRSController
};

use App\Http\Controllers\Dosen\{
    BiodataController as BiodataDosenController,
    KRSController as VerifikasiKRSController
};

use App\Http\Controllers\Akademika\{
    PesertaKelasKuliahController,
};

use App\Http\Controllers\LandingPage\{
    LandingPageController
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

Route::get('/home', [LandingPageController::class, 'index'])->name('landing_page.index');
Route::get('/berita', [LandingPageController::class, 'berita'])->name('landing_page.berita');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::group(['middleware' => ['Role:admin'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('/perguruan_tinggi', [PerguruanTinggiController::class, 'index'])->name('perguruan_tinggi.index');
    Route::post('/perguruan_tinggi/update', [PerguruanTinggiController::class, 'update'])->name('perguruan_tinggi.update');

    Route::resource('/program_studi', ProgramStudiController::class)->except(['show']);;
    Route::get('/program_studi/data_index', [ProgramStudiController::class, 'data_index'])->name('program_studi.data_index');

    Route::resource('/kurikulum', KurikulumController::class)->except(['show']);;
    Route::get('/kurikulum/data_index', [KurikulumController::class, 'data_index'])->name('kurikulum.data_index');
    
    Route::resource('/mata_kuliah', MataKuliahController::class)->except(['show']);;
    Route::get('/mata_kuliah/data_index', [MataKuliahController::class, 'data_index'])->name('mata_kuliah.data_index');
    
    Route::resource('/mata_kuliah_aktif', MataKuliahAktifController::class)->except(['show']);;
    Route::get('/mata_kuliah_aktif/data_index', [MataKuliahAktifController::class, 'data_index'])->name('mata_kuliah_aktif.data_index');

    Route::resource('/bobot_nilai', BobotNilaiController::class)->except(['show']);
    Route::get('/bobot_nilai/data_index', [BobotNilaiController::class, 'data_index'])->name('bobot_nilai.data_index');

    Route::resource('/kelas_kuliah', KelasKuliahController::class)->except(['show']);
    Route::get('/kelas_kuliah/data_index', [KelasKuliahController::class, 'data_index'])->name('kelas_kuliah.data_index');
    
    Route::resource('/ruang_kelas', RuangKelasController::class)->except(['show']);
    Route::get('/ruang_kelas/data_index', [RuangKelasController::class, 'data_index'])->name('ruang_kelas.data_index');
    
    Route::resource('/jadwal', JadwalController::class)->except(['show']);
    Route::get('/jadwal/data_index', [JadwalController::class, 'data_index'])->name('jadwal.data_index');

    Route::resource('/semester', SemesterController::class)->except(['show']);
    Route::get('/semester/data_index', [SemesterController::class, 'data_index'])->name('semester.data_index');
    
    Route::resource('/peserta_kelas_kuliah', PesertaKelasKuliahController::class)->except(['show', 'store']);
    Route::post('/peserta_kelas_kuliah/{kelas_kuliah}/store', [PesertaKelasKuliahController::class, 'store'])->name('peserta_kelas_kuliah.store');
    Route::get('/peserta_kelas_kuliah/{kelas_kuliah}/anggota', [PesertaKelasKuliahController::class, 'anggota'])->name('peserta_kelas_kuliah.anggota');
    Route::get('/peserta_kelas_kuliah/data_index', [PesertaKelasKuliahController::class, 'data_index'])->name('peserta_kelas_kuliah.data_index');
    Route::get('/peserta_kelas_kuliah/{id_kelas}/anggota_data_index', [PesertaKelasKuliahController::class, 'anggota_data_index'])->name('peserta_kelas_kuliah.anggota_data_index');


    Route::resource('/dosen', DosenController::class)->except(['show']);
    Route::get('/dosen/data_index', [DosenController::class, 'data_index'])->name('dosen.data_index');

    Route::get('/mahasiswa/data_index', [MahasiswaController::class, 'data_index'])->name('mahasiswa.data_index');
    Route::resource('/mahasiswa', MahasiswaController::class);

    Route::resource('mahasiswa/{id_mahasiswa}/riwayat_pendidikan', RiwayatPendidikanMHSController::class)->except(['show']);
    Route::get('mahasiswa/{id_mahasiswa}/riwayat_pendidikan/data_index', [RiwayatPendidikanMHSController::class, 'data_index'])->name('riwayat_pendidikan.data_index');
});


Route::group(['middleware' => ['Role:mahasiswa'], 'prefix' => 'mahasiswa', 'as' => 'mahasiswa.'], function () {
    Route::get('/biodata', [BiodataController::class, 'index'])->name('biodata.index');
    Route::put('/biodata/update', [BiodataController::class, 'update'])->name('biodata.update');

    Route::resource('/krs', KRSController::class)->except(['show']);;
    Route::get('/krs/data_index', [KRSController::class, 'data_index'])->name('krs.data_index');
});

Route::group(['middleware' => ['Role:dosen'], 'prefix' => 'dosen', 'as' => 'dosen.'], function () {
    Route::get('/biodata', [BiodataDosenController::class, 'index'])->name('biodata.index');
    Route::put('/biodata/update', [BiodataDosenController::class, 'update'])->name('biodata.update');

    Route::resource('/krs', VerifikasiKRSController::class)->except(['show']);;
    Route::get('/krs/data_index', [VerifikasiKRSController::class, 'data_index'])->name('krs.data_index');
    Route::post('/krs/{krs}/setujui', [VerifikasiKRSController::class, 'update_status'])->name('krs.update_status');

});
