<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
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
    SemesterMahasiswaController
};

use App\Http\Controllers\Mahasiswa\{BiodataController, KRSController};

use App\Http\Controllers\Dosen\{
    BiodataController as BiodataDosenController,
    KRSController as VerifikasiKRSController,
    VervalKRSController,
    JadwalMengajarController,
    NilaiController,
    JurnalPerkuliahanController
};

use App\Http\Controllers\Akademika\{PesertaKelasKuliahController};

use App\Http\Controllers\LandingPage\{LandingPageController};

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

Route::get('/home', [LandingPageController::class, 'index'])
    ->name('landing_page.index')
    ->middleware('cacheable:10');
Route::get('/berita', [LandingPageController::class, 'berita'])->name(
    'landing_page.berita'
);
Route::get('/kontak', [LandingPageController::class, 'kontak'])->name(
    'landing_page.kontak'
);

Route::post('/mata_kuliah_list', [
    MainController::class,
    'mata_kuliah_list',
])->name('mata_kuliah_list');
Route::post('/semester_list', [MainController::class, 'semester_list'])->name(
    'semester_list'
);

Route::get('/dashboard', function () {
    return view('dashboard');
})
    ->middleware(['auth'])
    ->name('dashboard');

require __DIR__ . '/auth.php';

Route::group(
    ['middleware' => ['Role:admin'], 'prefix' => 'admin', 'as' => 'admin.'],
    function () {
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

Route::group(
    [
        'middleware' => ['Role:mahasiswa'],
        'prefix' => 'mahasiswa',
        'as' => 'mahasiswa.',
    ],
    function () {
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

Route::group(
    ['middleware' => ['Role:dosen'], 'prefix' => 'dosen', 'as' => 'dosen.'],
    function () {
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
    
        Route::get('/pengisian_nilai', [
            NilaiController::class, 
            'index'
        ])->name('pengisian_nilai.index');
        Route::get('/pengisian_nilai/data_index', [
            NilaiController::class, 
            'data_index'
        ])->name('pengisian_nilai.data_index');
        Route::get('/pengisian_nilai/{id_jadwal}/form_nilai', [
            NilaiController::class, 
            'form_nilai'
        ])->name('pengisian_nilai.form_nilai');
        Route::post('/pengisian_nilai/store_nilai', [
            NilaiController::class, 
            'store_nilai'
        ])->name('pengisian_nilai.store_nilai');

        Route::resource('/jurnal_perkuliahan', JurnalPerkuliahanController::class)->except([
            'show',
            'index',
            'create',
        ]);
        Route::get('/jurnal_perkuliahan/{id_jadwal}/create', [
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
        Route::get('/jurnal_perkuliahan/{id_jadwal}/jurnal', [
            JurnalPerkuliahanController::class, 
            'jurnal_index'
        ])->name('jurnal_perkuliahan.jurnal_index');
        Route::get('/jurnal_perkuliahan/{id_jadwal}/jurnal_data_index', [
            JurnalPerkuliahanController::class, 
            'jurnal_data_index'
        ])->name('jurnal_perkuliahan.jurnal_data_index');
        Route::get('/jurnal_perkuliahan/{id_jadwal}/mahasiswa_data_index/{id_jurnal?}', [
            JurnalPerkuliahanController::class, 
            'list_mahasiswa'
        ])->name('jurnal_perkuliahan.mahasiswa_data_index');
        // Route::post('/jurnal_perkuliahan/{jurnal_perkuliahan}/update', [
        //     JurnalPerkuliahanController::class, 
        //     'update'
        // ])->name('jurnal_perkuliahan.update');
    }
);
