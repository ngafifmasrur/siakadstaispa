<nav class="horizontalMenu clearfix">
    <ul class="horizontalMenu-list">
        <li aria-haspopup="true"><a href="{{ route('mahasiswa.dashboard') }}" class=""><i class="typcn typcn-device-desktop hor-icon"></i> Dashboard</a></li>
        <li aria-haspopup="true"><a href="{{ route('mahasiswa.biodata.index') }}" class=""><i class="fa fa-user"></i> Profile</a></li>

        <li aria-haspopup="true"><a href="#" class="sub-icon {{ set_active(['mahasiswa/aktivitas_mahasiswa*', 'mahasiswa/aktivitas_perkuliahan*', 'mahasiswa/transkrip*', 'mahasiswa/histori_pendidikan*', 'mahasiswa/krs*', 'mahasiswa/histori_nilai*', 'mahasiswa/prestasi_mahasiswa*']) }}"><i class="fa fa-university"></i> Perkuliahan <i class="fa fa-angle-down horizontal-icon"></i></a>
            <ul class="sub-menu">
                <li aria-haspopup="true"><a href="{{ route('mahasiswa.aktivitas_mahasiswa.index') }}">Aktivitas Mahasiswa</a></li>
                <li aria-haspopup="true"><a href="{{ route('mahasiswa.aktivitas_perkuliahan.index' )}}">Aktivitas Perkuliahan</a></li>
                <li aria-haspopup="true"><a href="{{ route('mahasiswa.histori_pendidikan.index' )}}">Histori Pendidikan</a></li>
                <li aria-haspopup="true"><a href="{{ route('mahasiswa.histori_nilai.index' )}}">Histori Nilai</a></li>
                <li aria-haspopup="true"><a href="{{ route('mahasiswa.prestasi_mahasiswa.index') }}">Prestasi</a></li>
                <li aria-haspopup="true"><a href="{{ route('mahasiswa.transkrip.index' )}}">Transkrip</a></li>
            </ul>
        </li>
        <li aria-haspopup="true"><a href="{{ route('mahasiswa.krs.index') }}" class=""><i class="fa fa-book"></i> KRS Online</a></li>

        {{-- <li aria-haspopup="true"><a href="{{ route('mahasiswa.krs.index', date('Y')) }}" class=""><i class="fa fa-book"></i> KRS</a></li>
        <li aria-haspopup="true"><a href="{{ route('mahasiswa.prestasi_mahasiswa.index') }}" class=""><i class="fa fa-clipboard"></i> Prestasi</a></li> --}}
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