<nav class="horizontalMenu clearfix">
    <ul class="horizontalMenu-list">
        <li aria-haspopup="true"><a href="{{ route('dashboard') }}" class=""><i class="typcn typcn-device-desktop hor-icon"></i> Dashboard</a></li>
        <li aria-haspopup="true"><a href="{{ route('dosen.biodata.index') }}" class=""><i class="fa fa-user"></i> Biodata</a></li>

        <li aria-haspopup="true"><a href="#" class="sub-icon {{ set_active(['dosen/jurnal_perkuliahan*', 'dosen/pengisian_nilai*', 'dosen/jadwal_mengajar*', 'dosen/verval_krs*']) }}"><i class="fa fa-university"></i> Perkuliahan <i class="fa fa-angle-down horizontal-icon"></i></a>
            <ul class="sub-menu">
                <li aria-haspopup="true"><a href="{{ route('dosen.verval_krs.index') }}">Perwalian</a></li>
                <li aria-haspopup="true"><a href="{{ route('dosen.jadwal_mengajar.index') }}">Jadwal Mengajar</a></li>
                <li aria-haspopup="true"><a href="{{ route('dosen.pengisian_nilai.index') }}">Penilaian</a></li>
                <li aria-haspopup="true"><a href="{{ route('dosen.jurnal_perkuliahan.index') }}">Jurnal Perkuliahan</a></li>
            </ul>
        </li>

        <li aria-haspopup="true"><a href="#" class="sub-icon {{ set_active(['dosen/jurnal_perkuliahan*', 'dosen/pengisian_nilai*', 'dosen/jadwal_mengajar*', 'dosen/verval_krs*']) }}"><i class="fa fa-university"></i> Tridharma <i class="fa fa-angle-down horizontal-icon"></i></a>
            <ul class="sub-menu">
                <li aria-haspopup="true"><a href="{{ route('dosen.verval_krs.index') }}">Penelitian</a></li>
                <li aria-haspopup="true"><a href="{{ route('dosen.jadwal_mengajar.index') }}">Pengabdian</a></li>
                <li aria-haspopup="true"><a href="{{ route('dosen.pengisian_nilai.index') }}">Publikasi</a></li>
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