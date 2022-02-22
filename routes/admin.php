<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\Admin\{
    AktivitasController,
    AnggotaAktivitasController,
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
    DashboardController,
    DataPokokController,
    KonfigurasiController,
    RegistrasiMahasiswaController,
    PenugasanDosenController,
    SubstansiMataKuliahController,
    PeriodePerkuliahanController,
    PerkuliahanMahasiswaController,
    ManajemenUserController,
    PesertaKelasKuliahController,
    DosenPengajarKelasKuliahController,
    KurikurumProdiController,
    KonfigurasiGlobalController,
    DosenBelumNIDNController,
    BeritaController,
    DosenPembimbingController,
    DosenWaliController,
    InformasiController
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
        Route::get('/', fn () => redirect()->route('admin.dashboard'));
        Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('checkfeeder')->name(
            'dashboard'
        );
        Route::get('/perguruan_tinggi', [
            PerguruanTinggiController::class,
            'index',
        ])->middleware('checkfeeder')->name('perguruan_tinggi.index');
        Route::post('/perguruan_tinggi/update', [
            PerguruanTinggiController::class,
            'update',
        ])->name('perguruan_tinggi.update');

        Route::resource(
            '/program_studi',
            ProgramStudiController::class
        )->middleware('checkfeeder')->except(['show']);
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
        ])->middleware('checkfeeder')->name('kurikulum.data_index');

        Route::resource('/mata_kuliah', MataKuliahController::class)->except([
            'show',
        ]);
        Route::get('/mata_kuliah/data_index', [
            MataKuliahController::class,
            'data_index',
        ])->name('mata_kuliah.data_index');

        Route::resource('/bobot_nilai', BobotNilaiController::class)->except([
            'show',
        ]);
        Route::get('/bobot_nilai/data_index', [
            BobotNilaiController::class,
            'data_index',
        ])->name('bobot_nilai.data_index');

        Route::resource('/kelas_kuliah', KelasKuliahController::class)->except(['show']);
        Route::get('/kelas_kuliah/data_index', [KelasKuliahController::class,'data_index',])->name('kelas_kuliah.data_index');
        Route::get('/kelas_kuliah/mata_kuliah_by_prodi', [KelasKuliahController::class,'mata_kuliah_by_prodi',])->name('kelas_kuliah.mata_kuliah_by_prodi');

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

        // Route::resource(
        //     '/semester_mahasiswa',
        //     SemesterMahasiswaController::class
        // )->except(['show']);
        // Route::get('/semester_mahasiswa/data_index', [
        //     SemesterMahasiswaController::class,
        //     'data_index',
        // ])->name('semester_mahasiswa.data_index');
        // Route::get('/semester_mahasiswa/mahasiswa_data_index', [
        //     SemesterMahasiswaController::class,
        //     'mahasiswa_data_index',
        // ])->name('semester_mahasiswa.mahasiswa_data_index');
        // Route::post('/semester_mahasiswa/generate', [
        //     SemesterMahasiswaController::class,
        //     'generate',
        // ])->name('semester_mahasiswa.generate');

        // Route::resource(
        //     '/peserta_kelas_kuliah',
        //     PesertaKelasKuliahController::class
        // )->except(['show', 'store']);
        // Route::post('/peserta_kelas_kuliah/{kelas_kuliah}/store', [
        //     PesertaKelasKuliahController::class,
        //     'store',
        // ])->name('peserta_kelas_kuliah.store');
        // Route::get('/peserta_kelas_kuliah/{kelas_kuliah}/anggota', [
        //     PesertaKelasKuliahController::class,
        //     'anggota',
        // ])->name('peserta_kelas_kuliah.anggota');
        // Route::get('/peserta_kelas_kuliah/data_index', [
        //     PesertaKelasKuliahController::class,
        //     'data_index',
        // ])->name('peserta_kelas_kuliah.data_index');
        // Route::get('/peserta_kelas_kuliah/{id_kelas}/anggota_data_index', [
        //     PesertaKelasKuliahController::class,
        //     'anggota_data_index',
        // ])->name('peserta_kelas_kuliah.anggota_data_index');

        Route::resource('/dosen', DosenController::class)->except(['show']);
        Route::get('/dosen/data_index', [
            DosenController::class,
            'data_index',
        ])->name('dosen.data_index');
        Route::post('/dosen/buat_akun', [
            DosenController::class,
            'massCreateAccount',
        ])->name('dosen.buat_akun');

        Route::get('/mahasiswa/data_index', [
            MahasiswaController::class,
            'data_index',
        ])->name('mahasiswa.data_index');
        Route::post('/mahasiswa/buat_akun', [
            MahasiswaController::class,
            'massCreateAccount',
        ])->name('mahasiswa.buat_akun');
        Route::resource('/mahasiswa', MahasiswaController::class);

        Route::resource(
            'mahasiswa/{id_mahasiswa}/riwayat_pendidikan',
            RiwayatPendidikanMHSController::class
        )->except(['show']);
        Route::get('mahasiswa/{id_mahasiswa}/riwayat_pendidikan/data_index', [
            RiwayatPendidikanMHSController::class,
            'data_index',
        ])->name('riwayat_pendidikan.data_index');

        Route::get('/konfigurasi/data_index', [
            KonfigurasiController::class,
            'data_index',
        ])->name('konfigurasi.data_index');
        
        Route::resource('/konfigurasi', KonfigurasiController::class)->except([
            'show',
        ]);
        

        Route::get('/data_pokok/{master}', [
            DataPokokController::class,
            'index',
        ])->name('data_pokok.index');

        // Registrasi Mahasiswa / Riwayat Pendidikan Mahasiswa
        Route::get('registrasi_mahasiswa/data_index', [RegistrasiMahasiswaController::class, 'data_index',])->name('registrasi_mahasiswa.data_index');
        Route::resource('registrasi_mahasiswa', RegistrasiMahasiswaController::class);

        // Penugasan Dosen
        Route::resource('penugasan_dosen', PenugasanDosenController::class)->except(['show']);
        Route::get('penugasan_dosen/data_index', [PenugasanDosenController::class, 'data_index',])->name('penugasan_dosen.data_index');

        //Substansi Matkul
        Route::resource('substansi_mata_kuliah', SubstansiMataKuliahController::class)->except(['show']);
        Route::get('substansi_mata_kuliah/data_index', [SubstansiMataKuliahController::class, 'data_index',])->name('substansi_mata_kuliah.data_index');

        // Periode Perkulihan
        Route::get('periode_perkuliahan', [PeriodePerkuliahanController::class, 'index'])->name('periode_perkuliahan.index');
        Route::get('periode_perkuliahan/data_index', [PeriodePerkuliahanController::class, 'data_index',])->name('periode_perkuliahan.data_index');
        Route::delete('periode_perkuliahan/{id_prodi}/{id_mahasiswa}', [PeriodePerkuliahanController::class, 'destroy'])->name('periode_perkuliahan.destroy');
        Route::put('periode_perkuliahan/{id_prodi}/{id_mahasiswa}', [PeriodePerkuliahanController::class, 'update'])->name('periode_perkuliahan.update');
        Route::post('periode_perkuliahan', [PeriodePerkuliahanController::class, 'store'])->name('periode_perkuliahan.store');

        // Perkulihan Mahasiswa / Semester Mahasiswa
        Route::get('perkuliahan_mahasiswa', [PerkuliahanMahasiswaController::class, 'index'])->name('perkuliahan_mahasiswa.index');
        Route::get('perkuliahan_mahasiswa/data_index', [PerkuliahanMahasiswaController::class, 'data_index',])->name('perkuliahan_mahasiswa.data_index');
        Route::delete('perkuliahan_mahasiswa/{id_registrasi_mahasiswa}/{id_semester}', [PerkuliahanMahasiswaController::class, 'destroy'])->name('perkuliahan_mahasiswa.destroy');
        Route::put('perkuliahan_mahasiswa/{id_registrasi_mahasiswa}/{id_semester}', [PerkuliahanMahasiswaController::class, 'update'])->name('perkuliahan_mahasiswa.update');
        Route::post('perkuliahan_mahasiswa', [PerkuliahanMahasiswaController::class, 'store'])->name('perkuliahan_mahasiswa.store');


        // User Manajemen
        Route::resource('manajemen_user', ManajemenUserController::class)->except(['show']);
        Route::get('manajemen_user/data_index', [ManajemenUserController::class, 'data_index',])->name('manajemen_user.data_index');

        Route::get('manajemen_user/mahasiswa', [ManajemenUserController::class, 'mahasiswa',])->name('manajemen_user.mahasiswa');
        Route::get('manajemen_user/mahasiswa/data_index', [ManajemenUserController::class, 'mahasiswa_index',])->name('manajemen_user.mahasiswa_index');
        Route::post('manajemen_user/mahasiswa/generate', [ManajemenUserController::class, 'generate_user_mahasiswa',])->name('manajemen_user.generate_mahasiswa');

        Route::get('manajemen_user/dosen', [ManajemenUserController::class, 'dosen',])->name('manajemen_user.dosen');
        Route::get('manajemen_user/dosen/data_index', [ManajemenUserController::class, 'dosen_index',])->name('manajemen_user.dosen_index');
        Route::post('manajemen_user/dosen/generate', [ManajemenUserController::class, 'generate_user_dosen',])->name('manajemen_user.generate_dosen');

        // Peserta Kelas Kuliah
        Route::get('peserta_kelas_kuliah/{id_kelas_kuliah}', [PesertaKelasKuliahController::class, 'index'])->name('peserta_kelas_kuliah.index');
        Route::get('peserta_kelas_kuliah/data_index/{id_kelas_kuliah}', [PesertaKelasKuliahController::class, 'data_index',])->name('peserta_kelas_kuliah.data_index');
        Route::delete('peserta_kelas_kuliah/{id_kelas_kuliah}/{id_registrasi_mahasiswa}', [PesertaKelasKuliahController::class, 'destroy'])->name('peserta_kelas_kuliah.destroy');
        Route::put('peserta_kelas_kuliah/{id_kelas_kuliah}/{id_registrasi_mahasiswa}', [PesertaKelasKuliahController::class, 'update'])->name('peserta_kelas_kuliah.update');
        Route::post('peserta_kelas_kuliah/{id_kelas_kuliah}', [PesertaKelasKuliahController::class, 'store'])->name('peserta_kelas_kuliah.store');

        // Pengajar Kelas Kuliah
        Route::get('pengajar_kelas_kuliah/{id_kelas_kuliah}', [DosenPengajarKelasKuliahController::class, 'index'])->name('pengajar_kelas_kuliah.index');
        Route::get('pengajar_kelas_kuliah/data_index/{id_kelas_kuliah}', [DosenPengajarKelasKuliahController::class, 'data_index',])->name('pengajar_kelas_kuliah.data_index');
        Route::delete('pengajar_kelas_kuliah/{id_kelas_kuliah}', [DosenPengajarKelasKuliahController::class, 'destroy'])->name('pengajar_kelas_kuliah.destroy');
        Route::put('pengajar_kelas_kuliah/{id_kelas_kuliah}', [DosenPengajarKelasKuliahController::class, 'update'])->name('pengajar_kelas_kuliah.update');
        Route::post('pengajar_kelas_kuliah/{id_kelas_kuliah}', [DosenPengajarKelasKuliahController::class, 'store'])->name('pengajar_kelas_kuliah.store');

        // Kurikulum Prodi
        Route::resource('/kurikulum_prodi', KurikurumProdiController::class)->except(['show', 'create', 'destroy']);
        Route::get('/kurikulum_prodi/data_index/{id_kurikulum}/{id_prodi}', [KurikurumProdiController::class,'data_index',])->name('kurikulum_prodi.data_index');
        Route::get('/kurikulum_prodi/tabel/{id_kurikulum}/{id_prodi}', [KurikurumProdiController::class,'create',])->name('kurikulum_prodi.create');
        Route::delete('/kurikulum_prodi/delete/{id_kurikulum}/{id_matkul}', [KurikurumProdiController::class,'destroy',])->name('kurikulum_prodi.destroy');
        Route::get('/kurikulum_prodi/kurikulum_by_prodi', [KurikurumProdiController::class,'kurikulum_by_prodi',])->name('kurikulum_prodi.kurikulum_by_prodi');

        // aktivitas mahasiswa
        Route::get('aktivitas/data_index', [AktivitasController::class, 'data_index'])->name('aktivitas.data_index');
        Route::resource('aktivitas', AktivitasController::class);

        Route::get('anggota_aktivitas/data_index/{aktivitas}', [AnggotaAktivitasController::class, 'data_index'])->name('anggota_aktivitas.data_index');
        Route::get('anggota_aktivitas/{aktivitas}', [AnggotaAktivitasController::class, 'index'])->name('anggota_aktivitas.index');
        Route::resource('anggota_aktivitas', AnggotaAktivitasController::class)->except('index');

        // Konfigurasi Global
        Route::get('konfigurasi_global', [KonfigurasiGlobalController::class, 'index'])->name('konfigurasi_global.index');
        Route::get('konfigurasi_global/edit', [KonfigurasiGlobalController::class, 'edit'])->name('konfigurasi_global.edit');
        Route::post('konfigurasi_global', [KonfigurasiGlobalController::class, 'update'])->name('konfigurasi_global.update');

        // Dosen Belum NIDN
        Route::get('/dosen_belum_nidn/data_index', [DosenBelumNIDNController::class,'data_index',])->name('dosen_belum_nidn.data_index');
        Route::resource('/dosen_belum_nidn', DosenBelumNIDNController::class)->except(['show']);

        // Berita
        Route::get('/berita/data_index', [
            BeritaController::class,
            'data_index',
        ])->name('berita.data_index');
        Route::delete('berita/{berita}', [BeritaController::class, 'destroy'])->name('berita.destroy');
        Route::put('berita/{berita}', [BeritaController::class, 'update'])->name('berita.update');
        Route::get('berita', [BeritaController::class, 'index'])->name('berita.index');
        Route::post('berita', [BeritaController::class, 'store'])->name('berita.store');

        // Dosen Pembimbing
        Route::get('/dosen_pembimbing/data_index', [DosenPembimbingController::class,'data_index',])->name('dosen_pembimbing.data_index');
        Route::resource('/dosen_pembimbing', DosenPembimbingController::class)->except(['show']);

        // Dosen Wali
        Route::get('/dosen_wali/data_index', [DosenWaliController::class,'data_index',])->name('dosen_wali.data_index');
        Route::get('/dosen_wali/mahasiswa_data_index', [DosenWaliController::class, 'list_mahasiswa'])->name('dosen_wali.mahasiswa_data_index');
        Route::get('/dosen_wali/mahasiswa_wali_index/{dosen_wali}', [DosenWaliController::class, 'mahasiswa_wali_index'])->name('dosen_wali.mahasiswa_wali_index');
        Route::delete('/dosen_wali/copot/{id_registrasi_mahasiswa}', [DosenWaliController::class, 'copot'])->name('dosen_wali.copot');
        Route::post('/dosen_wali/copot_pilihan', [DosenWaliController::class, 'copot_pilihan'])->name('dosen_wali.copot_pilihan');
        Route::resource('/dosen_wali', DosenWaliController::class);

        // Pengaturan
        Route::get('/pengaturan_akun', [MainController::class, 'pengaturan_akun'])->name('pengaturan_akun');
        Route::post('/pengaturan_akun', [MainController::class, 'ganti_password'])->name('ganti_password');

        // Informasi
        Route::get('/informasi/data_index', [InformasiController::class,'data_index'])->name('informasi.data_index');
        Route::resource('/informasi', InformasiController::class)->except(['show']);
    }
);
