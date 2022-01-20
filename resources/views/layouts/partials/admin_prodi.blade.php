<nav class="horizontalMenu clearfix">
    <ul class="horizontalMenu-list">
        <li aria-haspopup="true"><a href="{{ route('admin_prodi.dashboard') }}" class=""><i class="typcn typcn-device-desktop hor-icon"></i> Dashboard</a></li>
        <li aria-haspopup="true"><a href="#" class="sub-icon {{ set_active(['admin_prodi/semester_mahasiswa*', 'admin_prodi/kurikulum_prodi*', 'admin_prodi/mata_kuliah*', 'admin_prodi/kelas_kuliah*','admin_prodi/jadwal*']) }}"><i class="fa fa-university"></i> Akademik <i class="fa fa-angle-down horizontal-icon"></i></a>
            <ul class="sub-menu">
                <li aria-haspopup="true"><a href="{{ route('admin_prodi.semester_mahasiswa.index') }}">Semester Mahasiswa</a></li>
                <li aria-haspopup="true"><a href="{{ route('admin_prodi.mata_kuliah.index') }}">Mata Kuliah</a></li>
                <li aria-haspopup="true"><a href="{{ route('admin_prodi.kurikulum_prodi.index') }}">Kurikulum Prodi</a></li>
                {{-- <li aria-haspopup="true"><a href="{{ route('admin_prodi.kelas_kuliah.index') }}">Kelas Kuliah</a></li> --}}
                <li aria-haspopup="true"><a href="{{ route('admin_prodi.jadwal.index') }}">Jadwal Kuliah</a></li>
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