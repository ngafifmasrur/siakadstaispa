@extends('layouts.app')
@section('title', 'Penugasan Dosen')

@section('content')

<x-header>
    Penugasan Dosen
</x-header>

<x-card>
    <div class="row">
        <div class="form-group col-lg-3">
            <label for="prodi">Program Studi</label>
            {!! Form::select('prodi', $prodi, null, ['class' => 'form-control', 'id' => 'prodi']) !!}
        </div>
        <div class="form-group col-lg-3">
            <label for="tahun_ajaran">Tahun Ajaran</label>
            {!! Form::select('tahun_ajaran', $tahun_ajaran, null, ['class' => 'form-control', 'id' => 'tahun_ajaran']) !!}
        </div>
    </div>
</x-card>

<x-card-table>
    <x-slot name="title">Data Penugasan Dosen</x-slot>
    <x-slot name="button">
        <a class="float-right btn btn-sm btn-outline-blue add-form" data-url="#" href="#"><i data-feather="plus" class="mr-2"></i>Tambah</a>
    </x-slot>

    <x-datatable 
    :route="route('admin.penugasan_dosen.data_index')" 
    :table="[
        ['title' => 'No.', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => 'false', 'searchable' => 'false', 'width' => '10'],                            
        ['title' => 'Nama Dosen', 'data' => 'nama_dosen', 'name' => 'nama_dosen'],
        ['title' => 'NIDN', 'data' => 'nidn', 'name' => 'nidn', 'classname' => 'text-left'],
        ['title' => 'Tahun Ajaran', 'data' => 'nama_tahun_ajaran', 'name' => 'nama_tahun_ajaran', 'classname' => 'text-left'],
        ['title' => 'Program Studi', 'data' => 'nama_program_studi', 'name' => 'nama_program_studi', 'classname' => 'text-left'],
        ['title' => 'Tgl Surat Tugas', 'data' => 'tanggal_surat_tugas', 'name' => 'tanggal_surat_tugas', 'classname' => 'text-left'],
        ['title' => 'Mulai Surat Tugas', 'data' => 'mulai_surat_tugas', 'name' => 'mulai_surat_tugas', 'classname' => 'text-left'],
        ['title' => 'Aksi', 'data' => 'action', 'orderable' => 'false', 'searchable' => 'false'],
    ]"
    :filter="[
        ['data' => 'prodi', 'value' => '$(`#prodi`).val()'],
        ['data' => 'tahun_ajaran', 'value' => '$(`#tahun_ajaran`).val()']
    ]"
    />

</x-card-table>

<x-modal.delete/>

@endsection

@push('js')
    <script>
        $( document ).ready(function() {
            $(document).on('change','#prodi, #tahun_ajaran',function(){
                table.ajax.reload();
            });
        });


        $('.add-form').on('click', function () {
            $('.modal-form').modal('show');
            $('.modal-form form')[0].reset();
            $('[name=_method]').val('post');
            $('.modal-form form').attr('action', $(this).data('url'));
        });

        $(document).on('click', '.btn_edit', function () {
            $('.modal-form').modal('show');
            $('.modal-form form')[0].reset();
            $('.modal-form form').attr('action',  $(this).data('route'));
            $('[name=_method]').val('put');
            var nim = $(this).data('nim');
            var id_jenis_daftar = $(this).data('id_jenis_daftar');
            var id_jalur_daftar = $(this).data('id_jalur_daftar');
            var id_periode_masuk = $(this).data('nama');
            var id_perguruan_tinggi = $(this).data('id_perguruan_tinggi');
            var id_prodi = $(this).data('id_prodi');
            var id_perguruan_tinggi_asal = $(this).data('id_perguruan_tinggi_asal');
            var id_prodi_asal = $(this).data('id_prodi_asal');
            var id_pembiayaan = $(this).data('id_pembiayaan');
            var sks_diakui = $(this).data('sks_diakui');

            $('[name=nim]').val(nim);
            $('[name=id_periode]').val(id_periode);
            $('[name=id_jenis_daftar]').val(id_jenis_daftar);
            $('[name=id_periode_masuk]').val(id_periode_masuk);
            $('[name=id_perguruan_tinggi]').val(id_perguruan_tinggi);
            $('[name=id_perguruan_tinggi_asal]').val(id_perguruan_tinggi_asal);
            $('[name=id_prodi_asal]').val(id_prodi_asal);
            $('[name=id_pembiayaan]').val(id_pembiayaan);
            $('[name=sks_diakui]').val(sks_diakui);
        });
    </script>
@endpush