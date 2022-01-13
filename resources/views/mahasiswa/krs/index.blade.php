@extends('layouts.app')
@section('title', 'KRS')

@section('content')

<x-header>
    KRS
</x-header>

<x-card>
    <div class="row">
        <div class="form-group col-lg-3">
            <label for="tahun_ajaran" class="font-weight-bold">Tahun Pelajaran</label>
            {!! Form::select('tahun_ajaran', $list_tahun_ajaran, null, ['class' => 'form-control', 'id' => 'tahun_ajaran']) !!}
        </div>
    </div>
</x-card>

<x-card-table>
    <x-slot name="title">KRS</x-slot>
    <x-slot name="button">
        <a class="btn btn-app btn-sm btn-primary add-form" data-url="{{ route('mahasiswa.krs.store') }}" href="#"><i class="fa fa-plus mr-2"></i>Tambah</a>
        <button class="btn btn-app btn-sm btn-success" onclick="document.getElementById('ajukan').submit();" {{ $semester_siswa->status_krs == 'Belum Mengajukan' ? '' : 'disabled'}}><i class="fa fa-check mr-2"></i>Ajukan</a>
        <form id="ajukan" action="{{ route('mahasiswa.krs.ajukan', $tahun_ajaran) }}" method="post">
            @csrf
        </form>
    </x-slot>

    <x-krs-table 
    :route="route('mahasiswa.krs.data_index', $tahun_ajaran)" 
    :table="[
        ['title' => 'No.', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => 'false', 'searchable' => 'false', 'width' => '10'],                            
        {{-- ['title' => 'Program Studi', 'data' => 'prodi', 'name' => 'prodi', 'classname' => 'text-left'], --}}
        ['title' => 'Kode', 'data' => 'kode_matkul', 'name' => 'kode_matkul'],
        ['title' => 'Nama Mata Kuliah', 'data' => 'matkul', 'name' => 'matkul','classname' => 'text-left'],
        ['title' => 'Nama Kelas', 'data' => 'kelas', 'name' => 'kelas','classname' => 'text-left'],
        ['title' => 'SKS', 'data' => 'sks', 'name' => 'sks'],
        ['title' => 'Dosen Pengajar', 'data' => 'dosen', 'name' => 'dosen', 'classname' => 'text-left'],
        ['title' => 'Ruangan', 'data' => 'ruangan', 'name' => 'ruangan','classname' => 'text-left'],
        ['title' => 'Jadwal', 'data' => 'jadwal', 'name' => 'jadwal'],
        ['title' => 'Status', 'data' => 'status', 'name' => 'status'],
        ['title' => 'Aksi', 'data' => 'action', 'orderable' => 'false', 'searchable' => 'false'],
    ]"
    />

</x-card-table>

<x-modal.delete/>

<x-modal class="modal-form" id="modal-form">
    <x-slot name="title">Daftar Jadwal Kuliah</x-slot>
    <x-slot name="modalPosition">modal-dialog-centered</x-slot>
    <x-slot name="modalDialogClass">modal-lg</x-slot>
    @csrf 
    @method('post')
    <div class="datatable">
        <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th style="width: 10%">Pilih</th>
                    <th>Prodi</th>
                    <th>Nama Dosen</th>
                    <th>Mata Kuliah</th>
                    <th>Ruangan</th>
                    <th class="text-center">Hari</th>
                    <th class="text-center">Jam Mulai</th>
                    <th class="text-center">Jam Selesai</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($jadwal as $data)
                <tr>
                    <td style="width: 10%" class="text-center"><input type="checkbox" name="jadwal[]" value="{{ $data->id }}"></td>
                    <td>{{ $data->prodi->nama_program_studi }}</td>
                    <td>{{ $data->dosen->nama_dosen }}</td>
                    <td>{{ $data->matkul->matkul_semester }}</td>
                    <td>{{ $data->ruangan->nama_ruangan }}</td>
                    <td class="text-center">{{ $data->hari }}</td>
                    <td class="text-center">{{ $data->jam_mulai }}</td>
                    <td class="text-center">{{ $data->jam_akhir }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <x-slot name="footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary">Tambah</button>
    </x-slot>
</x-modal>
@endsection

@push('js')
    <script>
        $('.add-form').on('click', function () {
            $('.modal-form').modal('show');
            $('.modal-form form')[0].reset();
            $('[name=_method]').val('post');
            $('.modal-form form').attr('action', $(this).data('url'));
        });
    </script>
@endpush