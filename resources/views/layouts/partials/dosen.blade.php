<nav class="horizontalMenu clearfix">
    <ul class="horizontalMenu-list">
        <li aria-haspopup="true"><a href="{{ route('dashboard') }}" class=""><i class="typcn typcn-device-desktop hor-icon"></i> Dashboard</a></li>
        <li aria-haspopup="true"><a href="{{ route('dosen.biodata.index') }}" class=""><i class="fa fa-user"></i> Biodata</a></li>
        <li aria-haspopup="true"><a href="{{ route('dosen.verval_krs.index') }}" class=""><i class="fa fa-book"></i> Verval KRS</a></li>
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