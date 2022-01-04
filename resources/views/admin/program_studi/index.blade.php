@extends('layouts.app')
@section('title', 'Program Studi')

@section('content')
<header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
    <div class="container">
        <div class="page-header-content pt-4">
            <div class="row align-items-center justify-content-between">
                <div class="col-auto mt-4">
                    <h1 class="page-header-title">
                        <div class="page-header-icon"><i data-feather="grid"></i></div>
                        Program Studi
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
                        Data Program Studi
                        <a class="float-right btn btn-sm btn-outline-blue add-form" data-url="{{ route('admin.program_studi.store') }}" href="#"><i data-feather="plus" class="mr-2"></i>Tambah</a>
                    </div>
                    
                    <div class="card-body">
                        <x-datatable 
                        :route="route('admin.program_studi.data_index')" 
                        :table="[
                            ['title' => 'No.', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => 'false', 'searchable' => 'false', 'width' => '10'],
                            ['title' => 'Kode', 'data' => 'kode_program_studi', 'name' => 'kode_program_studi'],
                            ['title' => 'Nama Program Studi', 'data' => 'nama_program_studi', 'name' => 'nama_program_studi', 'classname' => 'text-left'],
                            ['title' => 'Status', 'data' => 'status', 'name' => 'status'],
                            ['title' => 'Jenjang', 'data' => 'jenjang', 'name' => 'jenjang'],
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
    <x-slot name="title">Program Studi</x-slot>
    <x-slot name="modalPosition">modal-dialog-centered</x-slot>
    
    @csrf 
    @method('post')
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="kode_program_studi">Kode Program Studi</label>
            {!! Form::text('kode_program_studi', null, ['class' => 'form-control', 'id' => 'kode_program_studi']) !!}
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="nama_program_studi">Nama Program Studi</label>
            {!! Form::text('nama_program_studi', null, ['class' => 'form-control', 'id' => 'nama_program_studi']) !!}
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="id_jenjang_pendidikan">Jenjang</label>
            {!! Form::select('id_jenjang_pendidikan', $jenjang_pendidikan, null, ['class' => 'form-control', 'id' => 'id_jenjang_pendidikan']) !!}
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="status">Status</label>
            {!! Form::select('status', $status_prodi, null, ['class' => 'form-control', 'id' => 'status']) !!}
        </div>
    </div>

    <x-slot name="footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </x-slot>
</x-modal>

<x-modal class="edit-form" id="modal-form">
    <x-slot name="title">Program Studi</x-slot>
    <x-slot name="modalPosition">modal-dialog-centered</x-slot>
    @csrf
    @method('put')
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="kode_program_studi">Kode Program Studi</label>
            {!! Form::text('kode_program_studi', null, ['class' => 'form-control', 'id' => 'kode_program_studi']) !!}
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="nama_program_studi">Nama Program Studi</label>
            {!! Form::text('nama_program_studi', null, ['class' => 'form-control', 'id' => 'nama_program_studi']) !!}
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="id_jenjang_pendidikan">Jenjang</label>
            {!! Form::select('id_jenjang_pendidikan', $jenjang_pendidikan, null, ['class' => 'form-control', 'id' => 'id_jenjang_pendidikan']) !!}
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="status">Status</label>
            {!! Form::select('status', $status_prodi, null, ['class' => 'form-control', 'id' => 'status']) !!}
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
            $('.modal-form form').attr('action',  $(this).data('route'));
            $('[name=_method]').val('put');
            var kode_program_studi = $(this).data('kode');
            var nama_program_studi = $(this).data('nama');
            var id_jenjang_pendidikan = $(this).data('jenjang');
            var status = $(this).data('status');
            $('[name=kode_program_studi]').val(kode_program_studi);
            $('[name=nama_program_studi]').val(nama_program_studi);
            $('[name=id_jenjang_pendidikan]').val(id_jenjang_pendidikan);
            $('[name=status]').val(status);

        });
    </script>
@endpush