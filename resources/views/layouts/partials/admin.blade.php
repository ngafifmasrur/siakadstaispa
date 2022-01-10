<div id="layoutSidenav_nav">
    <nav class="sidenav shadow-right sidenav-light">
        <div class="sidenav-menu">
            <div class="nav accordion" id="accordionSidenav">
                <a class="nav-link" href="{{ route('dashboard') }}">
                    <div class="nav-link-icon"><i data-feather="grid"></i></div>
                    Dashboard
                </a>
                <!-- Sidenav Menu Heading (Core)-->
                <div class="sidenav-menu-heading">Master Data</div>
                <!-- Sidenav Accordion (Dashboard)-->
                <a class="nav-link collapsed" href="javascript:void(0);" data-toggle="collapse" data-target="#master" aria-expanded="false" aria-controls="master">
                    <div class="nav-link-icon"><i data-feather="briefcase"></i></div>
                    Master
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse {{ set_active(['admin/perguruan_tinggi*', 'admin/program_studi*']) }}" id="master" data-parent="#master">
                    <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                        <a class="nav-link" href="{{ route('admin.perguruan_tinggi.index') }}">Perguruan Tinggi</a>
                        <a class="nav-link" href="{{ route('admin.program_studi.index') }}">Program Studi</a>
                    </nav>
                </div>

                <a class="nav-link collapsed" href="javascript:void(0);" data-toggle="collapse" data-target="#akademik" aria-expanded="false" aria-controls="akademik">
                    <div class="nav-link-icon"><i data-feather="briefcase"></i></div>
                    Akademik
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse {{ set_active(['admin/semester*', 'admin/kurikulum*', 'admin/mata_kuliah*', 'admin/bobot_nilai*', 'admin/kelas_kuliah*','admin/jadwal*', 'admin/ruang_kelas*']) }}" id="akademik" data-parent="#akademik">
                    <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                        <a class="nav-link" href="{{ route('admin.semester.index') }}">Semester</a>
                        <a class="nav-link" href="{{ route('admin.kurikulum.index') }}">Kurikulum</a>
                        <a class="nav-link" href="{{ route('admin.mata_kuliah.index') }}">Mata Kuliah</a>
                        <a class="nav-link" href="{{ route('admin.mata_kuliah_aktif.index') }}">Mata Kuliah Aktif</a>
                        <a class="nav-link" href="{{ route('admin.bobot_nilai.index') }}">Bobot Nilai</a>
                        <a class="nav-link" href="{{ route('admin.kelas_kuliah.index') }}">Kelas Kuliah</a>
                        <a class="nav-link" href="{{ route('admin.ruang_kelas.index') }}">Ruang Kelas</a>
                        <a class="nav-link" href="{{ route('admin.jadwal.index') }}">Jadwal Kuliah</a>

                    </nav>
                </div>

                <a class="nav-link collapsed" href="javascript:void(0);" data-toggle="collapse" data-target="#civitas" aria-expanded="false" aria-controls="civitas">
                    <div class="nav-link-icon"><i data-feather="briefcase"></i></div>
                    Civitas
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse {{ set_active(['admin/dosen*', 'admin/mahasiswa*']) }}" id="civitas" data-parent="#civitas">
                    <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                        <a class="nav-link" href="{{ route('admin.dosen.index') }}">Data Dosen</a>
                        <a class="nav-link" href="{{ route('admin.mahasiswa.index') }}">Data Mahasiswa</a>
                    </nav>
                </div>
                <div class="sidenav-menu-heading">Akademika</div>
                {{-- <a class="nav-link collapsed" href="javascript:void(0);" data-toggle="collapse" data-target="#civitas" aria-expanded="false" aria-controls="krs">
                    <div class="nav-link-icon"><i data-feather="briefcase"></i></div>
                    KRS
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse {{ set_active(['admin/peserta_kelas_kuliah*']) }}" id="civitas" data-parent="#krs">
                    <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                        <a class="nav-link" href="{{ route('admin.peserta_kelas_kuliah.index') }}">Peserta Kelas Kuliah</a>
                    </nav>
                </div> --}}
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