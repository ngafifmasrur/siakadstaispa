<div id="layoutSidenav_nav">
    <nav class="sidenav shadow-right sidenav-light">
        <div class="sidenav-menu">
            <div class="nav accordion" id="accordionSidenav">
                <a class="nav-link" href="{{ route('dashboard') }}">
                    <div class="nav-link-icon"><i data-feather="grid"></i></div>
                    Dashboard
                </a>
                <!-- Sidenav Menu Heading (Core)-->
                <div class="sidenav-menu-heading">Biodata</div>
                <a class="nav-link" href="{{ route('mahasiswa.biodata.index') }}">
                    <div class="nav-link-icon"><i data-feather="user"></i></div>
                    Biodata
                </a>
                <div class="sidenav-menu-heading">Akademik</div>
                <a class="nav-link" href="{{ route('mahasiswa.krs.index') }}">
                    <div class="nav-link-icon"><i data-feather="book-open"></i></div>
                    KRS
                </a>

            </div>
        </div>
        <!-- Sidenav Footer-->
        <div class="sidenav-footer">
            <div class="sidenav-footer-content">
                <div class="sidenav-footer-subtitle">Logged in as:</div>
                <div class="sidenav-footer-title">{{ Auth::user()->name }}</div>
            </div>
        </div>
    </nav>
</div>

@push('js')
    <script>
    $(function () {
            $('select').selectpicker({
                liveSearch: true,
            });
        });
    </script>
@endpush