@extends('layouts.app')
@section('title', 'Dosen')

@section('content')
<header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
    <div class="container">
        <div class="page-header-content pt-4">
            <div class="row align-items-center justify-content-between">
                <div class="col-auto mt-4">
                    <h1 class="page-header-title">
                        <div class="page-header-icon"><i data-feather="grid"></i></div>
                        Dosen
                    </h1>
                    {{-- <div class="page-header-subtitle">Example dashboard overview and content summary</div> --}}
                </div>
            </div>
        </div>
    </div>
</header>
<!-- Main page content-->
<div class="container mt-n10">
    <div class="row">
        <div class="col-lg-12">
            <form action="" method="post">
                <div class="card">
                    <div class="card-header">
                        Data Dosen
                        <a class="float-right btn btn-sm btn-outline-blue add-form"
                            data-url="{{ route('admin.dosen.store') }}" href="#"><i data-feather="plus"
                                class="mr-2"></i>Tambah</a>
                    </div>

                    <div class="card-body">
                        <x-datatable :route="route('admin.dosen.data_index')" :table="[
                            ['title' => 'No.', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => 'false', 'searchable' => 'false', 'width' => '10'],
                            ['title' => 'NIDN', 'data' => 'nidn', 'name' => 'nidn', 'classname' => 'text-left'],
                            ['title' => 'Nama', 'data' => 'nama_dosen', 'name' => 'nama_dosen', 'classname' => 'text-left'],
                            ['title' => 'Kontak', 'data' => 'kontak', 'name' => 'kontak', 'classname' => 'text-left'],
                        ]" />
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>

<x-modal.delete />

<x-modal class="modal-form" id="modal-form">
    <x-slot name="title">Dosen</x-slot>
    <x-slot name="modalPosition">modal-dialog-centered</x-slot>

    @csrf
    @method('post')
    <div class="form-group row">
        <label for="nidn" class="col-sm-3 col-form-label">NIDN<span class="text-danger">*</span> </label>
        <div class="col-sm-9">
            {!! Form::number('nidn', null, ['class' => 'form-control', 'id' => 'nidn', 'required']) !!}
        </div>
    </div>
    <div class="form-group row">
        <label for="nip" class="col-sm-3 col-form-label">NIP<span class="text-danger">*</span></label>
        <div class="col-sm-9">
            {!! Form::number('nip', null, ['class' => 'form-control', 'id' => 'nip', 'required']) !!}
        </div>
    </div>
    <div class="form-group row">
        <label for="nik" class="col-sm-3 col-form-label">NIK<span class="text-danger">*</span></label>
        <div class="col-sm-9">
            {!! Form::number('nik', null, ['class' => 'form-control', 'id' => 'nik', 'required']) !!}
        </div>
    </div>
    <div class="form-group row">
        <label for="npwp" class="col-sm-3 col-form-label">NPWP<span class="text-danger">*</span></label>
        <div class="col-sm-9">
            {!! Form::number('npwp', null, ['class' => 'form-control', 'id' => 'npwp', 'required']) !!}
        </div>
    </div>
    <div class="form-group row">
        <label for="nama_dosen" class="col-sm-3 col-form-label">Nama Lengkap Dosen<span class="text-danger">*</span></label>
        <div class="col-sm-9">
            {!! Form::text('nama_dosen', null, ['class' => 'form-control', 'id' => 'nama_dosen', 'required']) !!}
        </div>
    </div>
    <div class="form-group row">
        <label for="tempat_lahir" class="col-sm-3 col-form-label">Tempat Lahir<span class="text-danger">*</span></label>
        <div class="col-sm-9">
            {!! Form::text('tempat_lahir', null, ['class' => 'form-control', 'id' => 'tempat_lahir', 'required']) !!}
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
                <input class="form-check-input" type="radio" name="jenis_kelamin" id="Laki-laki" value="Laki-laki">
                <label class="form-check-label" for="Laki-laki">Laki-laki</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="jenis_kelamin" id="Perempuan" value="Perempuan">
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

<x-modal class="edit-form" id="modal-form">
    <x-slot name="title">Kurikulum</x-slot>
    <x-slot name="modalPosition">modal-dialog-centered</x-slot>
    @csrf
    @method('put')
    <div class="form-group row">
        <label for="nidn" class="col-sm-3 col-form-label">NIDN</label>
        <div class="col-sm-9">
            {!! Form::number('nidn', null, ['class' => 'form-control', 'id' => 'nidn']) !!}
        </div>
    </div>
    <div class="form-group row">
        <label for="nip" class="col-sm-3 col-form-label">NIP</label>
        <div class="col-sm-9">
            {!! Form::number('nip', null, ['class' => 'form-control', 'id' => 'nip']) !!}
        </div>
    </div>
    <div class="form-group row">
        <label for="nik" class="col-sm-3 col-form-label">NIK</label>
        <div class="col-sm-9">
            {!! Form::number('nik', null, ['class' => 'form-control', 'id' => 'nik']) !!}
        </div>
    </div>
    <div class="form-group row">
        <label for="npwp" class="col-sm-3 col-form-label">NPWP</label>
        <div class="col-sm-9">
            {!! Form::number('npwp', null, ['class' => 'form-control', 'id' => 'npwp']) !!}
        </div>
    </div>
    <div class="form-group row">
        <label for="nama_dosen" class="col-sm-3 col-form-label">Nama Lengkap Dosen</label>
        <div class="col-sm-9">
            {!! Form::text('nama_dosen', null, ['class' => 'form-control', 'id' => 'nama_dosen']) !!}
        </div>
    </div>
    <div class="form-group row">
        <label for="tempat_lahir" class="col-sm-3 col-form-label">Tempat Lahir</label>
        <div class="col-sm-9">
            {!! Form::text('tempat_lahir', null, ['class' => 'form-control', 'id' => 'tempat_lahir']) !!}
        </div>
    </div>
    <div class="form-group row">
        <label for="tanggal_lahir" class="col-sm-3 col-form-label">Tanggal Lahir</label>
        <div class="col-sm-9">
            {!! Form::date('tanggal_lahir', null, ['class' => 'form-control', 'id' => 'tanggal_lahir']) !!}
        </div>
    </div>
    <div class="form-group row">
        <label for="tanggal_lahir" class="col-sm-3 col-form-label">Jenis Kelamin</label>
        <div class="col-sm-9 mt-2">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="jenis_kelamin" id="Laki-laki" value="Laki-laki">
                <label class="form-check-label" for="Laki-laki">Laki-laki</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="jenis_kelamin" id="Perempuan" value="Perempuan">
                <label class="form-check-label" for="Perempuan">Perempuan</label>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <label for="id_agama" class="col-sm-3 col-form-label">Agama</label>
        <div class="col-sm-9">
            {!! Form::select('id_agama', $agama, null, ['class' => 'form-control', 'id' => 'id_agama']) !!}
        </div>
    </div>
    <div class="form-group row">
        <label for="tanggal_lahir" class="col-sm-3 col-form-label">Status Aktif</label>
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
        var id_agama = $(this).data('id_agama');
        var nidn = $(this).data('nama');
        var id_status_aktif = $(this).data('semester');
        var jumlah_sks_lulus = $(this).data('sks_lulus');
        var jumlah_sks_wajib = $(this).data('sks_wajib');
        var jumlah_sks_pilihan = $(this).data('sks_pilihan');

        $('[name=id_status_aktif]').val(id_status_aktif);
        $('[name=nidn]').val(nidn);
        $('[name=id_agama]').val(id_agama);
        $('[name=jumlah_sks_lulus]').val(jumlah_sks_lulus);
        $('[name=jumlah_sks_wajib]').val(jumlah_sks_wajib);
        $('[name=jumlah_sks_pilihan]').val(jumlah_sks_pilihan);

    });

</script>
@endpush
