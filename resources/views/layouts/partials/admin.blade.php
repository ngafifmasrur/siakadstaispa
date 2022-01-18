<nav class="horizontalMenu clearfix">
    <ul class="horizontalMenu-list">
        <li aria-haspopup="true"><a href="{{ route('admin.dashboard') }}" class=""><i class="typcn typcn-device-desktop hor-icon"></i> Dashboard</a></li>

        <li aria-haspopup="true"><a href="#" class="sub-icon {{ set_active(['admin/perguruan_tinggi*', 'admin/program_studi*']) }}"><i class="typcn typcn-th-large-outline hor-icon"></i> Master <i class="fa fa-angle-down horizontal-icon"></i></a>
            <ul class="sub-menu">
                <li aria-haspopup="true"><a href="{{ route('admin.perguruan_tinggi.index') }}">Perguruan Tinggi</a></li>
                <li aria-haspopup="true"><a href="{{ route('admin.program_studi.index') }}">Program Studi</a></li>
            </ul>
        </li>
        <li aria-haspopup="true"><a href="#" class="sub-icon {{ set_active(['admin/semester*', 'admin/semester_mahasiswa*', 'admin/tahun_ajaran*', 'admin/kurikulum_prodi*', 'admin/mata_kuliah*', 'admin/bobot_nilai*', 'admin/kelas_kuliah*','admin/jadwal*', 'admin/ruang_kelas*']) }}"><i class="fa fa-university"></i> Akademik <i class="fa fa-angle-down horizontal-icon"></i></a>
            <ul class="sub-menu">
                <li aria-haspopup="true"><a href="{{ route('admin.tahun_ajaran.index') }}">Tahun Ajaran</a></li>
                <li aria-haspopup="true"><a href="{{ route('admin.semester.index') }}">Semester</a></li>
                <li aria-haspopup="true"><a href="{{ route('admin.semester_mahasiswa.index') }}">Semester Mahasiswa</a></li>
                {{-- <li aria-haspopup="true"><a href="{{ route('admin.kurikulum.index') }}">Kurikulum</a></li> --}}
                <li aria-haspopup="true"><a href="{{ route('admin.mata_kuliah.index') }}">Mata Kuliah</a></li>
                <li aria-haspopup="true"><a href="{{ route('admin.kurikulum_prodi.index') }}">Kurikulum Prodi</a></li>
                <li aria-haspopup="true"><a href="{{ route('admin.bobot_nilai.index') }}">Bobot Nilai</a></li>
                <li aria-haspopup="true"><a href="{{ route('admin.kelas_kuliah.index') }}">Kelas Kuliah</a></li>
                <li aria-haspopup="true"><a href="{{ route('admin.ruang_kelas.index') }}">Ruang Kelas</a></li>
                <li aria-haspopup="true"><a href="{{ route('admin.jadwal.index') }}">Jadwal Kuliah</a></li>
            </ul>
        </li>
        <li aria-haspopup="true"><a href="#" class="sub-icon {{ set_active(['admin/dosen*', 'admin/mahasiswa*']) }}"><i class="fa fa-graduation-cap"></i> Civitas <i class="fa fa-angle-down horizontal-icon"></i></a>
            <ul class="sub-menu">
                <li aria-haspopup="true"><a href="{{ route('admin.dosen.index') }}">Data Dosen</a></li>
                <li aria-haspopup="true"><a href="{{ route('admin.mahasiswa.index') }}">Data Mahasiswa</a></li>
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