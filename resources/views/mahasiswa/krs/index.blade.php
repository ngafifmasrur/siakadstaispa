@extends('layouts.app')
@section('title', 'KRS')

@section('content')

<x-header>
    KRS
</x-header>
<!-- Main page content-->
<div class="container mt-n10">
    <div class="row">
        <div class="col-lg-12">
            <form action="" method="post">
                <div class="card">
                    <div class="card-header">
                        KRS
                        <a class="float-right btn btn-sm btn-outline-blue add-form" data-url="{{ route('mahasiswa.krs.store') }}" href="#"><i data-feather="plus" class="mr-2"></i>Ambil Jadwal Kuliah</a>
                    </div>
                    
                    <div class="card-body">
                        @if ($errors->any())
                        <div class="alert alert-danger alert-icon" role="alert">
                            <button class="close" type="button" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                            <div class="alert-icon-content">
                                <h6 class="alert-heading">Error, Periksa Ulang data..</h6>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        @endif

                        <x-datatable 
                        :route="route('mahasiswa.krs.data_index')" 
                        :table="[
                            ['title' => 'No.', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => 'false', 'searchable' => 'false', 'width' => '10'],                            
                            ['title' => 'Program Studi', 'data' => 'prodi', 'name' => 'prodi', 'classname' => 'text-left'],
                            ['title' => 'Nama Dosen', 'data' => 'dosen', 'name' => 'dosen', 'classname' => 'text-left'],
                            ['title' => 'Mata Kuliah', 'data' => 'matkul', 'name' => 'matkul','classname' => 'text-left'],
                            ['title' => 'Kelas', 'data' => 'kelas', 'name' => 'kelas','classname' => 'text-left'],
                            ['title' => 'Ruangan', 'data' => 'ruangan', 'name' => 'ruangan','classname' => 'text-left'],
                            ['title' => 'Hari', 'data' => 'hari', 'name' => 'hari'],
                            ['title' => 'Jam Mulai', 'data' => 'jam_mulai', 'name' => 'jam_mulai'],
                            ['title' => 'Jam Selesai', 'data' => 'jam_selesai', 'name' => 'jam_selesai'],
                            ['title' => 'Status', 'data' => 'status', 'name' => 'status'],
                            ['title' => 'Aksi', 'data' => 'action', 'orderable' => 'false', 'searchable' => 'false'],
                        ]"
                        />
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>

<x-modal.delete/>

<x-modal class="modal-form" id="modal-form">
    <x-slot name="title">Daftar Jadwal Kuliah</x-slot>
    <x-slot name="modalPosition">modal-dialog-centered</x-slot>
    <x-slot name="modalDialogClass">modal-xl</x-slot>
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