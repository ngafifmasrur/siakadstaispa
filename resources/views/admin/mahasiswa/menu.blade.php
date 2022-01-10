<div class="nav-sticky">
    <div class="card">
        <div class="card-body">
            <ul class="nav flex-column" id="stickyNav">
                <li class="nav-item"><a class="nav-link" href="{{ route('admin.mahasiswa.show', $mahasiswa->id)}}">Detail Mahasiswa</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('admin.riwayat_pendidikan.index', ['id_mahasiswa' => $mahasiswa->id])}}">Riwayat Pendidikan</a></li>
                <li class="nav-item"><a class="nav-link" href="#colors">Prestasi</a></li>
            </ul>
        </div>
    </div>
</div>