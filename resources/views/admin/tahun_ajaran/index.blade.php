@extends('layouts.app')
@section('title', 'Tahun Ajaran')

@section('content')

<x-header>
    Tahun Ajaran
</x-header>
<!-- Main page content-->
<x-card-table>
    <x-slot name="title">Data Tahun Ajaran</x-slot>
    <x-slot name="button">
        <a class="btn btn-app btn-sm btn-primary add-form" data-url="{{ route('admin.tahun_ajaran.store') }}" href="#"><i class="fa fa-plus mr-2"></i>Tambah</a>
    </x-slot>

    <x-datatable 
    :route="route('admin.tahun_ajaran.data_index')" 
    :table="[
        ['title' => 'No.', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => 'false', 'searchable' => 'false', 'width' => '10'],  
        ['title' => 'Tahun Ajaran', 'data' => 'id_tahun_ajaran', 'name' => 'id_tahun_ajaran'],                          
        ['title' => 'Nama Tahun Ajaran', 'data' => 'nama_tahun_ajaran', 'name' => 'nama_tahun_ajaran', 'classname' => 'text-left'],
        ['title' => 'Status', 'data' => 'aktif', 'name' => 'aktif'],
        ['title' => 'Tanggal Mulai', 'data' => 'tanggal_mulai', 'name' => 'tanggal_mulai'],
        ['title' => 'Tanggal Selesai', 'data' => 'tanggal_selesai', 'name' => 'tanggal_selesai'],
        ['title' => 'Aksi', 'data' => 'action', 'orderable' => 'false', 'searchable' => 'false'],
    ]"
    />

</x-card-table>

<x-modal.delete/>

<x-modal class="modal-form" id="modal-form">
    <x-slot name="title">Tahun Ajaran</x-slot>
    <x-slot name="modalPosition">modal-dialog-centered</x-slot>
    
    @csrf 
    @method('post')
    @php
        $years = [];
        for ($year=2000; $year <= date('Y'); $year++) $years[$year] = $year;
    @endphp
    <div class="row">
        <div class="form-group col-lg-6">
            <label for="id_tahun_ajaran">Tahun Ajaran</label>
            {!! Form::select('id_tahun_ajaran', $years, NULL, ['class' => 'form-control '.($errors->has('id_tahun_ajaran') ? 'is-invalid' : ''), 'id' => 'id_tahun_ajaran']) !!}
            @error('id_tahun_ajaran')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group col-lg-6">
            <label for="nama_tahun_ajaran">Nama Tahun Ajaran</label>
            {!! Form::text('nama_tahun_ajaran', null, ['class' => 'form-control '.($errors->has('nama_tahun_ajaran') ? 'is-invalid' : ''), 'id' => 'nama_tahun_ajaran']) !!}
            @error('nama_tahun_ajaran')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="row">
        <div class="form-group col-lg-6">
            <label for="tanggal_mulai">Tanggal Mulai</label>
            {!! Form::date('tanggal_mulai', null, ['class' => 'form-control '.($errors->has('tanggal_mulai') ? 'is-invalid' : ''), 'id' => 'tanggal_mulai']) !!}
            @error('tanggal_mulai')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group col-lg-6">
            <label for="tanggal_selesai">Tanggal Selesai</label>
            {!! Form::date('tanggal_selesai', null, ['class' => 'form-control '.($errors->has('tanggal_selesai') ? 'is-invalid' : ''), 'id' => 'tanggal_selesai']) !!}
            @error('tanggal_selesai')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>   
    <div class="row">
        <div class="form-group col-lg-6">
            <label for="a_periode_aktif">Periode Aktif</label>
            {!! Form::select('a_periode_aktif', [1 => 'Ya', 0 => 'Tidak'], null, ['class' => 'form-control '.($errors->has('a_periode_aktif') ? 'is-invalid' : ''), 'id' => 'a_periode_aktif']) !!}
            @error('a_periode_aktif')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <x-slot name="footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </x-slot>
</x-modal>

<x-modal class="edit-form" id="modal-form">
    <x-slot name="title">Semester</x-slot>
    <x-slot name="modalPosition">modal-dialog-centered</x-slot>
    @csrf
    @method('put')
    <div class="row">
        <div class="form-group col-lg-6">
            <label for="id_tahun_ajaran">Tahun Ajaran</label>
            {!! Form::select('id_tahun_ajaran', $years, NULL, ['class' => 'form-control '.($errors->has('id_tahun_ajaran') ? 'is-invalid' : ''), 'id' => 'id_tahun_ajaran']) !!}
            @error('id_tahun_ajaran')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group col-lg-6">
            <label for="nama_tahun_ajaran">Nama Tahun Ajaran</label>
            {!! Form::text('nama_tahun_ajaran', null, ['class' => 'form-control '.($errors->has('nama_tahun_ajaran') ? 'is-invalid' : ''), 'id' => 'nama_tahun_ajaran']) !!}
            @error('nama_tahun_ajaran')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="row">
        <div class="form-group col-lg-6">
            <label for="tanggal_mulai">Tanggal Mulai</label>
            {!! Form::date('tanggal_mulai', null, ['class' => 'form-control '.($errors->has('tanggal_mulai') ? 'is-invalid' : ''), 'id' => 'tanggal_mulai']) !!}
            @error('tanggal_mulai')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group col-lg-6">
            <label for="tanggal_selesai">Tanggal Selesai</label>
            {!! Form::date('tanggal_selesai', null, ['class' => 'form-control '.($errors->has('tanggal_selesai') ? 'is-invalid' : ''), 'id' => 'tanggal_selesai']) !!}
            @error('tanggal_selesai')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>   
    <div class="row">
        <div class="form-group col-lg-6">
            <label for="a_periode_aktif">Periode Aktif</label>
            {!! Form::select('a_periode_aktif', [1 => 'Ya', 0 => 'Tidak'], null, ['class' => 'form-control '.($errors->has('a_periode_aktif') ? 'is-invalid' : ''), 'id' => 'a_periode_aktif']) !!}
            @error('a_periode_aktif')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
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
            var id_tahun_ajaran = $(this).data('id_tahun_ajaran');
            var nama_tahun_ajaran = $(this).data('nama_tahun_ajaran');
            var a_periode_aktif = $(this).data('a_periode_aktif');
            var tanggal_mulai = $(this).data('tanggal_mulai');
            var tanggal_selesai = $(this).data('tanggal_selesai');

            $('[name=id_tahun_ajaran]').val(id_tahun_ajaran);
            $('[name=nama_tahun_ajaran]').val(nama_tahun_ajaran);
            $('[name=a_periode_aktif]').val(a_periode_aktif);
            $('[name=tanggal_mulai]').val(tanggal_mulai);
            $('[name=tanggal_selesai]').val(tanggal_selesai);

        });
        
    </script>
@endpush