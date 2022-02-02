@extends('layouts.app')
@section('title', 'Substansi Mata Kuliah')

@section('content')

<x-header>
    Substansi Mata Kuliah
</x-header>

<x-card-table>
    <x-slot name="title">Data Substansi Mata Kuliah</x-slot>
    <x-slot name="button">
        <a class="float-right btn btn-sm btn-outline-blue add-form" data-url="#" href="#"><i data-feather="plus" class="mr-2"></i>Tambah</a>
    </x-slot>

    <x-datatable 
    :route="route('admin.substansi_mata_kuliah.data_index')" 
    :table="[
        ['title' => 'No.', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => 'false', 'searchable' => 'false', 'width' => '10'],                            
        ['title' => 'Program Studi', 'data' => 'nama_program_studi', 'name' => 'nama_program_studi', 'classname' => 'text-left'],
        ['title' => 'Substansi', 'data' => 'nama_substansi', 'name' => 'nama_substansi', 'classname' => 'text-left'],
        ['title' => 'SKS Mata Kuliah', 'data' => 'sks_mata_kuliah', 'name' => 'sks_mata_kuliah'],
        ['title' => 'SKS Tatap Muka', 'data' => 'sks_tatap_muka', 'name' => 'sks_tatap_muka'],
        ['title' => 'SKS Praktek', 'data' => 'sks_praktek', 'name' => 'sks_praktek'],
        ['title' => 'SKS Praktek Lapangan', 'data' => 'sks_praktek_lapangan', 'name' => 'sks_praktek_lapangan'],
        ['title' => 'SKS Simulasi', 'data' => 'sks_simulasi', 'name' => 'sks_simulasi'],
        ['title' => 'Jenis Substansi', 'data' => 'nama_jenis_substansi', 'name' => 'nama_jenis_substansi', 'classname' => 'text-left'],
        ['title' => 'Aksi', 'data' => 'action', 'orderable' => 'false', 'searchable' => 'false'],
    ]"
    />

</x-card-table>

<x-modal.delete/>

@endsection

@push('js')
    <script>
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