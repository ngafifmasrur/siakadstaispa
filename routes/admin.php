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
    SemesterController,
    TahunAjaranController,
    SemesterMahasiswaController,
    DashboardController
};

use App\Http\Controllers\Akademika\{
    PesertaKelasKuliahController
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
    ['middleware' => ['Role:admin'], 'as' => 'admin.'],
    function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name(
            'dashboard'
        );
        Route::get('/perguruan_tinggi', [
            PerguruanTinggiController::class,
            'index',
        ])->name('perguruan_tinggi.index');
        Route::post('/perguruan_tinggi/update', [
            PerguruanTinggiController::class,
            'update',
        ])->name('perguruan_tinggi.update');

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

        Route::resource('/bobot_nilai', BobotNilaiController::class)->except([
            'show',
        ]);
        Route::get('/bobot_nilai/data_index', [
            BobotNilaiController::class,
            'data_index',
        ])->name('bobot_nilai.data_index');

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
        Route::get('/ruang_kelas/data_index', [
            RuangKelasController::class,
            'data_index',
        ])->name('ruang_kelas.data_index');

        Route::resource('/jadwal', JadwalController::class)->except(['show']);
        Route::get('/jadwal/data_index', [
            JadwalController::class,
            'data_index',
        ])->name('jadwal.data_index');

        Route::resource('/tahun_ajaran', TahunAjaranController::class)->except([
            'show',
        ]);
        Route::get('/tahun_ajaran/data_index', [
            TahunAjaranController::class,
            'data_index',
        ])->name('tahun_ajaran.data_index');

        Route::resource('/semester', SemesterController::class)->except([
            'show',
        ]);
        Route::get('/semester/data_index', [
            SemesterController::class,
            'data_index',
        ])->name('semester.data_index');

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

        Route::resource(
            '/peserta_kelas_kuliah',
            PesertaKelasKuliahController::class
        )->except(['show', 'store']);
        Route::post('/peserta_kelas_kuliah/{kelas_kuliah}/store', [
            PesertaKelasKuliahController::class,
            'store',
        ])->name('peserta_kelas_kuliah.store');
        Route::get('/peserta_kelas_kuliah/{kelas_kuliah}/anggota', [
            PesertaKelasKuliahController::class,
            'anggota',
        ])->name('peserta_kelas_kuliah.anggota');
        Route::get('/peserta_kelas_kuliah/data_index', [
            PesertaKelasKuliahController::class,
            'data_index',
        ])->name('peserta_kelas_kuliah.data_index');
        Route::get('/peserta_kelas_kuliah/{id_kelas}/anggota_data_index', [
            PesertaKelasKuliahController::class,
            'anggota_data_index',
        ])->name('peserta_kelas_kuliah.anggota_data_index');

        Route::resource('/dosen', DosenController::class)->except(['show']);
        Route::get('/dosen/data_index', [
            DosenController::class,
            'data_index',
        ])->name('dosen.data_index');

        Route::get('/mahasiswa/data_index', [
            MahasiswaController::class,
            'data_index',
        ])->name('mahasiswa.data_index');
        Route::resource('/mahasiswa', MahasiswaController::class);

        Route::resource(
            'mahasiswa/{id_mahasiswa}/riwayat_pendidikan',
            RiwayatPendidikanMHSController::class
        )->except(['show']);
        Route::get('mahasiswa/{id_mahasiswa}/riwayat_pendidikan/data_index', [
            RiwayatPendidikanMHSController::class,
            'data_index',
        ])->name('riwayat_pendidikan.data_index');
    }
);