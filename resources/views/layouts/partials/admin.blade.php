<nav class="horizontalMenu clearfix">
    <ul class="horizontalMenu-list">
        <li aria-haspopup="true"><a href="{{ route('admin.dashboard') }}" class=""><i class="typcn typcn-device-desktop hor-icon"></i> Dashboard</a></li>
        <li aria-haspopup="true"><a href="#" class="sub-icon {{ set_active(['admin/perguruan_tinggi*', 'admin/program_studi*']) }}"><i class="typcn typcn-th-large-outline hor-icon"></i> Profile <i class="fa fa-angle-down horizontal-icon"></i></a>
            <ul class="sub-menu">
                <li aria-haspopup="true"><a href="{{ route('admin.perguruan_tinggi.index') }}">Perguruan Tinggi</a></li>
                <li aria-haspopup="true"><a href="{{ route('admin.program_studi.index') }}">Program Studi</a></li>
            </ul>
        </li>
        <li aria-haspopup="true"><a href="#" class="sub-icon {{ set_active(['admin/dosen*', 'admin/mahasiswa*','admin/dosen_belum_nidn*']) }}"><i class="fa fa-graduation-cap"></i> Civitas <i class="fa fa-angle-down horizontal-icon"></i></a>
            <ul class="sub-menu">
                <li aria-haspopup="true"><a href="{{ route('admin.dosen.index') }}">Data Dosen</a></li>
                <li aria-haspopup="true"><a href="{{ route('admin.dosen_belum_nidn.index') }}">Data Dosen Belum NIDN</a></li>
                <li aria-haspopup="true"><a href="{{ route('admin.mahasiswa.index') }}">Data Mahasiswa</a></li>
            </ul>
        </li>
        {{-- <li aria-haspopup="true"><a href="#" class="sub-icon {{ set_active(['admin/perguruan_tinggi*', 'admin/program_studi*', 'admin/konfigurasi*']) }}"><i class="typcn typcn-th-large-outline hor-icon"></i> Master <i class="fa fa-angle-down horizontal-icon"></i></a>
            <ul class="sub-menu">
                <li aria-haspopup="true"><a href="{{ route('admin.perguruan_tinggi.index') }}">Perguruan Tinggi</a></li>
                <li aria-haspopup="true"><a href="{{ route('admin.program_studi.index') }}">Program Studi</a></li>


                <li aria-haspopup="true"><a href="{{ route('admin.aktivitas.index') }}" class="">Kegiatan Mahasiswa</a></li>
            </ul>
        </li> --}}
        <li aria-haspopup="true"><a href="#" class="sub-icon {{ set_active(['admin/dosen_wali*','admin/penugasan_dosen*', 'admin/perkuliahan_mahasiswa*', 'admin/kurikulum_prodi*', 'admin/mata_kuliah*', 'admin/bobot_nilai*', 'admin/kelas_kuliah*','admin/jadwal*', 'admin/ruang_kelas*']) }}"><i class="fa fa-university"></i> Perkuliahan <i class="fa fa-angle-down horizontal-icon"></i></a>
            <ul class="sub-menu">
                <li aria-haspopup="true"><a href="{{ route('admin.periode_perkuliahan.index') }}">Periode Perkuliahan</a></li>
                <li aria-haspopup="true"><a href="{{ route('admin.mata_kuliah.index') }}">Mata Kuliah</a></li>
                <li aria-haspopup="true"><a href="{{ route('admin.substansi_mata_kuliah.index') }}">Substansi Mata Kuliah</a></li>
                <li aria-haspopup="true"><a href="{{ route('admin.kurikulum.index') }}">Kurikulum</a></li>
                <li aria-haspopup="true"><a href="{{ route('admin.kurikulum_prodi.index') }}">Kurikulum Prodi</a></li>
                <li aria-haspopup="true"><a href="{{ route('admin.dosen_wali.index') }}">Perwalian Dosen</a></li>
                <li aria-haspopup="true"><a href="{{ route('admin.penugasan_dosen.index') }}">Penugasan Dosen</a></li>
                <li aria-haspopup="true"><a href="{{ route('admin.kelas_kuliah.index') }}">Kelas Perkuliahan</a></li>
                <li aria-haspopup="true"><a href="{{ route('admin.registrasi_mahasiswa.index') }}">Registrasi Mahasiswa</a></li>
                <li aria-haspopup="true"><a href="{{ route('admin.perkuliahan_mahasiswa.index') }}">Perkuliahan Mahasiswa</a></li>
                <li aria-haspopup="true"><a href="{{ route('admin.bobot_nilai.index') }}">Bobot Nilai</a></li>
                {{-- <li aria-haspopup="true"><a href="{{ route('admin.ruang_kelas.index') }}">Ruang Kelas</a></li>
                <li aria-haspopup="true"><a href="{{ route('admin.jadwal.index') }}">Jadwal Kuliah</a></li> --}}
            </ul>
        </li>

        <li aria-haspopup="true"><a href="#" class="sub-icon {{ set_active(['admin/semester*', 'admin/manajemen_user*','admin/tahun_ajaran*', 'admin/konfigurasi*']) }}"><i class="fa fa-gear"></i> Pengaturan <i class="fa fa-angle-down horizontal-icon"></i></a>
            <ul class="sub-menu">
                <li aria-haspopup="true"><a href="{{ route('admin.tahun_ajaran.index') }}">Tahun Ajaran</a></li>
                <li aria-haspopup="true"><a href="{{ route('admin.semester.index') }}">Semester</a></li>
                <li aria-haspopup="true"><a href="{{ route('admin.konfigurasi.index') }}">Konfigurasi Feeder</a></li>
                <li aria-haspopup="true"><a href="{{ route('admin.konfigurasi_global.index') }}">Konfigurasi Global</a></li>
                <li aria-haspopup="true"><a href="{{ route('admin.berita.index') }}">Berita</a></li>
                <li aria-haspopup="true"><a href="#" class="sub-icon {{ set_active([
                    'admin/manajemen_user/mahasiswa',
                    'admin/manajemen_user/dosen',
                    'admin/manajemen_user',
                ]) }}">Manajemen Users <i class="fa fa-angle-down horizontal-icon float-right mt-1"></i></a>
                    <ul class="sub-menu" style="overflow-y: scroll; height: auto;">
                        <li aria-haspopup="true"><a href="{{ route('admin.manajemen_user.index') }}">Daftar User</a></li>
                        <li aria-haspopup="true"><a href="{{ route('admin.manajemen_user.mahasiswa') }}">Generate User Mahasiswa</a></li>
                        <li aria-haspopup="true"><a href="{{ route('admin.manajemen_user.dosen') }}">Generate User Dosen</a></li>
                    </ul>
                </li>            
            </ul>
        </li>
        <li aria-haspopup="true"><a href="#" class="sub-icon {{ set_active([
            'admin/data_pokok/periode',
            'admin/data_pokok/pembiayaan',
            'admin/data_pokok/jenis_prestasi',
            'admin/data_pokok/tingkat_prestasi',
            'admin/data_pokok/jenis_aktivitas_mahasiswa',
            'admin/data_pokok/kategori_kegiatan',
            'admin/data_pokok/agama',
            'admin/data_pokok/bentuk_pendidikan',
            'admin/data_pokok/ikatan_kerja_sdm',
            'admin/data_pokok/jabfung',
            'admin/data_pokok/jalur_masuk',
            'admin/data_pokok/jenis_evaluasi',
            'admin/data_pokok/jenis_keluar',
            'admin/data_pokok/jenis_sertifikasi',
            'admin/data_pokok/jenis_pendaftaran',
            'admin/data_pokok/jenis_sms',
            'admin/data_pokok/jenis_substansi',
            'admin/data_pokok/jenis_tinggal',
            'admin/data_pokok/jenjang_pendidikan',
            'admin/data_pokok/kebutuhan_khusus',
            'admin/data_pokok/lembaga_pengangkat',
            'admin/data_pokok/level_wilayah',
            'admin/data_pokok/wilayah',
            'admin/data_pokok/negara',
            'admin/data_pokok/pangkat_golongan',
            'admin/data_pokok/pekerjaan',
            'admin/data_pokok/penghasilan',
            'admin/data_pokok/status_keaktifan_pegawai',
            'admin/data_pokok/status_kepegawaian',
            'admin/data_pokok/status_mahasiswa',
        ]) }}"> <i class="typcn typcn-th-large-outline hor-icon"></i> Data Pokok <i class="fa fa-angle-down horizontal-icon"></i></a>
            <ul class="sub-menu sub-menu-data-pokok" style="overflow-y: scroll; height: 400px;">
                <li aria-haspopup="true"><a href="{{ route('admin.data_pokok.index', ['master' => 'periode']) }}">Periode</a></li>
                <li aria-haspopup="true"><a href="{{ route('admin.data_pokok.index', ['master' => 'pembiayaan']) }}">Pembiayaan</a></li>
                <li aria-haspopup="true"><a href="{{ route('admin.data_pokok.index', ['master' => 'jenis_prestasi']) }}">Jenis Prestasi</a></li>
                <li aria-haspopup="true"><a href="{{ route('admin.data_pokok.index', ['master' => 'tingkat_prestasi']) }}">Tingkat Prestasi</a></li>
                <li aria-haspopup="true"><a href="{{ route('admin.data_pokok.index', ['master' => 'jenis_aktivitas_mahasiswa']) }}">Jenis Aktivitas Mahasiswa</a></li>
                <li aria-haspopup="true"><a href="{{ route('admin.data_pokok.index', ['master' => 'kategori_kegiatan']) }}">Kategori Kegiatan</a></li>
                <li aria-haspopup="true"><a href="{{ route('admin.data_pokok.index', ['master' => 'agama']) }}">Agama</a></li>
                <li aria-haspopup="true"><a href="{{ route('admin.data_pokok.index', ['master' => 'bentuk_pendidikan']) }}">Bentuk Pendidikan</a></li>
                <li aria-haspopup="true"><a href="{{ route('admin.data_pokok.index', ['master' => 'ikatan_kerja_sdm']) }}">Ikatan kerja SDM</a></li>
                <li aria-haspopup="true"><a href="{{ route('admin.data_pokok.index', ['master' => 'jabfung']) }}">JabFung</a></li>
                <li aria-haspopup="true"><a href="{{ route('admin.data_pokok.index', ['master' => 'jalur_masuk']) }}">Jalur Masuk</a></li>
                <li aria-haspopup="true"><a href="{{ route('admin.data_pokok.index', ['master' => 'jenis_evaluasi']) }}">Jenis Evaluasi</a></li>
                <li aria-haspopup="true"><a href="{{ route('admin.data_pokok.index', ['master' => 'jenis_keluar']) }}">Jenis Keluar</a></li>
                <li aria-haspopup="true"><a href="{{ route('admin.data_pokok.index', ['master' => 'jenis_sertifikasi']) }}">Jenis Sertifikasi</a></li>
                <li aria-haspopup="true"><a href="{{ route('admin.data_pokok.index', ['master' => 'jenis_pendaftaran']) }}">Jenis Pendaftaran</a></li>
                <li aria-haspopup="true"><a href="{{ route('admin.data_pokok.index', ['master' => 'jenis_sms']) }}">Jenis SMS</a></li>
                <li aria-haspopup="true"><a href="{{ route('admin.data_pokok.index', ['master' => 'jenis_substansi']) }}">Jenis Substansi</a></li>
                <li aria-haspopup="true"><a href="{{ route('admin.data_pokok.index', ['master' => 'jenis_tinggal']) }}">Jenis Tinggal</a></li>
                <li aria-haspopup="true"><a href="{{ route('admin.data_pokok.index', ['master' => 'jenjang_pendidikan']) }}">Jenjang Pendidikan</a></li>
                <li aria-haspopup="true"><a href="{{ route('admin.data_pokok.index', ['master' => 'kebutuhan_khusus']) }}">Kebutuhan Khusus</a></li>
                <li aria-haspopup="true"><a href="{{ route('admin.data_pokok.index', ['master' => 'lembaga_pengangkat']) }}">Lembaga Pengangkat</a></li>
                <li aria-haspopup="true"><a href="{{ route('admin.data_pokok.index', ['master' => 'level_wilayah']) }}">Level Wilayah</a></li>
                <li aria-haspopup="true"><a href="{{ route('admin.data_pokok.index', ['master' => 'wilayah']) }}">Wilayah</a></li>
                <li aria-haspopup="true"><a href="{{ route('admin.data_pokok.index', ['master' => 'negara']) }}">Negara</a></li>
                <li aria-haspopup="true"><a href="{{ route('admin.data_pokok.index', ['master' => 'pangkat_golongan']) }}">Pangkat Golongan</a></li>
                <li aria-haspopup="true"><a href="{{ route('admin.data_pokok.index', ['master' => 'pekerjaan']) }}">Pekerjaan</a></li>
                <li aria-haspopup="true"><a href="{{ route('admin.data_pokok.index', ['master' => 'penghasilan']) }}">Penghasilan</a></li>
                <li aria-haspopup="true"><a href="{{ route('admin.data_pokok.index', ['master' => 'status_keaktifan_pegawai']) }}">Status Keaktifan Pegawai</a></li>
                <li aria-haspopup="true"><a href="{{ route('admin.data_pokok.index', ['master' => 'status_kepegawaian']) }}">Status Kepegawaian</a></li>
                <li aria-haspopup="true"><a href="{{ route('admin.data_pokok.index', ['master' => 'status_mahasiswa']) }}">Status Mahasiswa</a></li>
            </ul>
        </li>
    </ul>
</nav>

@push('js')
    <script>
    $(function () {
            $('select').selectpicker({
                liveSearch: true,
            });
        });
    </script>
@endpush