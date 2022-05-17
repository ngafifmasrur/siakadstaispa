<nav class="horizontalMenu clearfix">
    <ul class="horizontalMenu-list">
        <li aria-haspopup="true"><a href="{{ route('bendahara.dashboard') }}" class=""><i class="typcn typcn-device-desktop hor-icon"></i> Dashboard</a></li>

        <li aria-haspopup="true"><a href="#" class="sub-icon {{ set_active(['bendahara/presensi_dosen*', 'bendahara/presensi_mahasiswa*']) }}"><i class="fa fa-university"></i> Presensi <i class="fa fa-angle-down horizontal-icon"></i></a>
            <ul class="sub-menu">
                <li aria-haspopup="true"><a href="{{ route('bendahara.presensi_dosen.index') }}">Dosen</a></li>
                <li aria-haspopup="true"><a href="{{ route('bendahara.presensi_mahasiswa.index') }}">Mahasiswa</a></li>
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