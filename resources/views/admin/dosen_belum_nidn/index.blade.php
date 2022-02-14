@extends('layouts.app')
@section('title', 'Dosen Belum NIDN')

@section('content')

<x-header>
    Dosen Belum NIDN
</x-header>

<x-card-table>
    <x-slot name="title">Data Dosen Belum NIDN</x-slot>
    <x-slot name="button">
        <a class="btn btn-app btn-sm btn-primary add-form" data-url="{{ route('admin.dosen_belum_nidn.store') }}" href="#"><i class="fa fa-plus mr-2"></i>Tambah</a>
        {{-- <button onclick="massCreateAccount('{{ route('admin.dosen.buat_akun') }}')" class="btn btn-success btn-xs btn-flat"><i class="fa fa-check"></i> Buat Akun</button> --}}

    </x-slot>
    
        <x-datatable
        :route="route('admin.dosen_belum_nidn.data_index')"
        :table="[
            ['title' => 'No.', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => 'false', 'searchable' => 'false', 'width' => '10'],
            ['title' => 'Nama', 'data' => 'nama_dosen', 'name' => 'nama_dosen', 'classname' => 'text-left'],
            ['title' => 'NIP', 'data' => 'nip', 'name' => 'nip', 'classname' => 'text-left'],
            ['title' => 'Jenis Kelamin', 'data' => 'jenis_kelamin', 'name' => 'jenis_kelamin', 'classname' => 'text-left'],
            ['title' => 'Status Aktif', 'data' => 'status', 'name' => 'status', 'classname' => 'text-center'],
            ['title' => 'Aksi', 'data' => 'action', 'orderable' => 'false', 'searchable' => 'false']
        ]"/>

</x-card-table>

<x-modal.delete />

<x-modal class="modal-form" id="modal-form">
    <x-slot name="title">Dosen Belum NIDN</x-slot>
    <x-slot name="modalPosition">modal-dialog-centered</x-slot>

    @csrf
    @method('post')
    <div class="form-group row">
        <label for="nip" class="col-sm-3 col-form-label">NIP<span class="text-danger">*</span></label>
        <div class="col-sm-9">
            {!! Form::number('nip', null, ['class' => 'form-control', 'id' => 'nip', 'required']) !!}
        </div>
    </div>
    <div class="form-group row">
        <label for="nama_dosen" class="col-sm-3 col-form-label">Nama Lengkap Dosen<span class="text-danger">*</span></label>
        <div class="col-sm-9">
            {!! Form::text('nama_dosen', null, ['class' => 'form-control', 'id' => 'nama_dosen', 'required']) !!}
        </div>
    </div>
    <div class="form-group row">
        <label for="tanggal_lahir" class="col-sm-3 col-form-label">Tanggal Lahir<span class="text-danger">*</span></label>
        <div class="col-sm-9">
            {!! Form::date('tanggal_lahir', null, ['class' => 'form-control', 'id' => 'tanggal_lahir', 'required']) !!}
        </div>
    </div>
    <div class="form-group row">
        <label for="tanggal_lahir" class="col-sm-3 col-form-label">Jenis Kelamin<span class="text-danger">*</span></label>
        <div class="col-sm-9 mt-2">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="jenis_kelamin" id="Laki-laki" value="L">
                <label class="form-check-label" for="Laki-laki">Laki-laki</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="jenis_kelamin" id="Perempuan" value="P">
                <label class="form-check-label" for="Perempuan">Perempuan</label>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <label for="id_agama" class="col-sm-3 col-form-label">Agama<span class="text-danger">*</span></label>
        <div class="col-sm-9">
            {!! Form::select('id_agama', $agama, null, ['class' => 'form-control', 'id' => 'id_agama']) !!}
        </div>
    </div>
    <div class="form-group row">
        <label for="tanggal_lahir" class="col-sm-3 col-form-label">Status Aktif<span class="text-danger">*</span></label>
        <div class="col-sm-9 mt-2">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="id_status_aktif" id="aktif" value="1">
                <label class="form-check-label" for="aktif">Aktif</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="id_status_aktif" id="non_aktif" value="0">
                <label class="form-check-label" for="non_aktif">Non Aktif</label>
            </div>
        </div>
    </div>
    <x-slot name="footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </x-slot>
</x-modal>

@endsection

@push('css')
    <style>
        .row {
            display: flex!important;
        }
    </style>
@endpush

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
        $('.modal-form form').attr('action', $(this).data('route'));
        $('[name=_method]').val('put');
        var nama_dosen = $(this).data('nama_dosen');
        var nip = $(this).data('nip');
        var tanggal_lahir = $(this).data('tanggal_lahir');
        var id_agama = $(this).data('id_agama');
        var id_status_aktif = $(this).data('id_status_aktif');
        var jenis_kelamin = $(this).data('jenis_kelamin');

        $('[name=nama_dosen]').val(nama_dosen);
        $('[name=nip]').val(nip);
        $('[name=tanggal_lahir]').val(tanggal_lahir);
        $('[name=id_agama]').val(id_agama);
        $('[name=id_status_aktif]').val(id_status_aktif);
        $('[name=jenis_kelamin]').val(jenis_kelamin);
    });


</script>
@endpush
