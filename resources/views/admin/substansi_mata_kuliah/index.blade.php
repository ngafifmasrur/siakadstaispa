@extends('layouts.app')
@section('title', 'Substansi Mata Kuliah')

@section('content')

<x-header>
    Substansi Mata Kuliah
</x-header>

<x-card>
    <div class="row">
        <div class="form-group col-lg-3">
            <label for="prodi">Program Studi</label>
            {!! Form::select('prodi', $prodi, null, ['class' => 'form-control', 'id' => 'prodi']) !!}
        </div>
    </div>
</x-card>

<x-card-table>
    <x-slot name="title">Data Substansi Mata Kuliah</x-slot>
    <x-slot name="button">
        <a class="btn btn-app btn-sm btn-primary add-form" data-url="{{ route('admin.substansi_mata_kuliah.store') }}" href="#"><i class="fa fa-plus mr-2"></i>Tambah</a>
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
    :filter="[
        ['data' => 'prodi', 'value' => '$(`#prodi`).val()']
    ]"
    />

</x-card-table>

<x-modal.delete/>

<x-modal class="modal-form" id="modal-form">
    <x-slot name="title">Substansi Mata Kuliah</x-slot>
    <x-slot name="modalPosition">modal-dialog-centered</x-slot>
    
    @csrf 
    @method('post')
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="id_prodi">Program Studi</label>
            {!! Form::select('id_prodi', $prodi, null, ['class' => 'form-control', 'id' => 'id_prodi']) !!}
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="nama_substansi">Nama Substansi</label>
            {!! Form::text('nama_substansi', null, ['class' => 'form-control', 'id' => 'nama_substansi']) !!}
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="sks_mata_kuliah">SKS Mata Kuliah</label>
            {!! Form::number('sks_mata_kuliah', null, ['class' => 'form-control', 'id' => 'sks_mata_kuliah']) !!}
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="sks_tatap_muka">SKS Tatap Muka</label>
            {!! Form::number('sks_tatap_muka', null, ['class' => 'form-control', 'id' => 'sks_tatap_muka']) !!}
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="sks_praktek">SKS Praktek</label>
            {!! Form::number('sks_praktek', null, ['class' => 'form-control', 'id' => 'sks_praktek']) !!}
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="sks_simulasi">SKS Simulasi</label>
            {!! Form::number('sks_simulasi', null, ['class' => 'form-control', 'id' => 'sks_simulasi']) !!}
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="id_jenis_substansi">Jenis Evaluasi</label>
            {!! Form::select('id_jenis_substansi', $jenis_evaluasi, null, ['class' => 'form-control', 'id' => 'id_jenis_substansi']) !!}
        </div>
    </div>

    <x-slot name="footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </x-slot>
</x-modal>
@endsection

@push('js')
    <script>
        $( document ).ready(function() {
            $(document).on('change','#prodi',function(){
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
            var id_prodi = $(this).data('id_prodi');
            var nama_substansi = $(this).data('nama_substansi');
            var sks_mata_kuliah = $(this).data('sks_mata_kuliah');
            var sks_tatap_muka = $(this).data('sks_tatap_muka');
            var sks_praktek_lapangan = $(this).data('sks_praktek_lapangan');
            var id_jenis_substansi = $(this).data('id_jenis_substansi');
            var sks_simulasi = $(this).data('sks_simulasi');
            var sks_praktek = $(this).data('sks_praktek');

            $('[name=id_prodi]').val(id_prodi);
            $('[name=nama_substansi]').val(nama_substansi);
            $('[name=sks_mata_kuliah]').val(sks_mata_kuliah);
            $('[name=sks_tatap_muka]').val(sks_tatap_muka);
            $('[name=sks_praktek_lapangan]').val(sks_praktek_lapangan);
            $('[name=id_jenis_substansi]').val(id_jenis_substansi);
            $('[name=sks_simulasi]').val(sks_simulasi);
            $('[name=sks_praktek]').val(sks_praktek);
        });
    </script>
@endpush