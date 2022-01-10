@extends('layouts.app')
@section('title', 'Kelas Kuliah')

@section('content')

<x-header>
    Peserta Kelas Kuliah
</x-header>
<!-- Main page content-->
<div class="container mt-n10">
    <div class="row">
        <div class="col-lg-12">
            <form action="" method="post">
                <div class="card">
                    <div class="card-header">
                        Peserta Kelas Kuliah
                        <a class="float-right btn btn-sm btn-outline-blue add-form" data-url="{{ route('admin.peserta_kelas_kuliah.store', $kelas_kuliah) }}" href="#"><i data-feather="plus" class="mr-2"></i>Tambah</a>
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
                        :route="route('admin.peserta_kelas_kuliah.anggota_data_index', $kelas_kuliah)" 
                        :table="[
                            ['title' => 'No.', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => 'false', 'searchable' => 'false', 'width' => '10'],                            
                            ['title' => 'NIM', 'data' => 'nim', 'name' => 'nim'],
                            ['title' => 'Nama Mahasiswa', 'data' => 'nama_mahasiswa', 'name' => 'nama_mahasiswa', 'classname' => 'text-left'],
                            ['title' => 'Periode Masuk', 'data' => 'periode_masuk', 'name' => 'periode_masuk'],
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
    <x-slot name="title">Daftar Mahasiswa</x-slot>
    <x-slot name="modalPosition">modal-dialog-centered</x-slot>
    
    @csrf 
    @method('post')
    <div class="datatable">
        <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>Pilih</th>
                    <th>NIM</th>
                    <th>Nama Mahasiswa</th>
                    <th>Periode</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($mahasiswa as $data)
                <tr>
                    <td style="width: 10%" class="text-center"><input type="checkbox" name="peserta[]" value="{{ $data->id }}"></td>
                    <td>{{ $data->nim }}</td>
                    <td>{{ $data->mahasiswa->nama_mahasiswa }}</td>
                    <td>{{ $data->periode->nama_semester }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <x-slot name="footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary">Tambah Peserta Kelas</button>
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