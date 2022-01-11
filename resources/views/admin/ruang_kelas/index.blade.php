@extends('layouts.app')
@section('title', 'Ruang Kelas')

@section('content')

<x-header>
    Ruang Kelas
</x-header>

<x-card-table>
    <x-slot name="title">Data Ruang Kelas</x-slot>
    <x-slot name="button">
        <a class="btn btn-app btn-sm btn-primary add-form" data-url="{{ route('admin.ruang_kelas.store') }}" href="#"><i class="fa fa-plus mr-2"></i>Tambah</a>
    </x-slot>
    
    <x-datatable 
    :route="route('admin.ruang_kelas.data_index')" 
    :table="[
        ['title' => 'No.', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => 'false', 'searchable' => 'false', 'width' => '10'],
        ['title' => 'Nama Ruangan', 'data' => 'nama_ruangan', 'name' => 'nama_ruangan', 'classname' => 'text-left'],
        ['title' => 'Kapasitas', 'data' => 'kapasitas', 'name' => 'kapasitas', 'width' => '10%'],
        ['title' => 'Keterangan', 'data' => 'keterangan', 'name' => 'keterangan', 'classname' => 'text-left'],
        ['title' => 'Status', 'data' => 'status', 'name' => 'status', 'classname' => 'text-center'],
        ['title' => 'Aksi', 'data' => 'action', 'orderable' => 'false', 'searchable' => 'false'],
    ]"
    />
</x-card-table>

<x-modal.delete/>

<x-modal class="modal-form" id="modal-form">
    <x-slot name="title">Ruang Kelas</x-slot>
    <x-slot name="modalPosition">modal-dialog-centered</x-slot>
    
    @csrf 
    @method('post')
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="nama_ruangan">Nama Ruangan</label>
            {!! Form::text('nama_ruangan', null, ['class' => 'form-control '.($errors->has('nama_ruangan') ? 'is-invalid' : ''), 'id' => 'nama_ruangan']) !!}
            @error('nama_ruangan')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="kapasitas">Kapasitas</label>
            {!! Form::number('kapasitas', null, ['class' => 'form-control '.($errors->has('kapasitas') ? 'is-invalid' : ''), 'id' => 'kapasitas']) !!}
            @error('kapasitas')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="keterangan">Keterangan</label>
            {!! Form::text('keterangan', null, ['class' => 'form-control '.($errors->has('keterangan') ? 'is-invalid' : ''), 'id' => 'keterangan']) !!}
            @error('keterangan')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="aktif">Aktif</label>
            {!! Form::select('aktif', [1 => 'Ya',0 => 'Tidak'], null, ['class' => 'form-control '.($errors->has('aktif') ? 'is-invalid' : ''), 'id' => 'aktif']) !!}
            @error('aktif')
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
    <x-slot name="title">Ruang Kelas</x-slot>
    <x-slot name="modalPosition">modal-dialog-centered</x-slot>
    @csrf
    @method('put')
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="nama_ruangan">Nama Ruangan</label>
            {!! Form::text('nama_ruangan', null, ['class' => 'form-control '.($errors->has('nama_ruangan') ? 'is-invalid' : ''), 'id' => 'nama_ruangan']) !!}
            @error('nama_ruangan')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="kapasitas">Kapasitas</label>
            {!! Form::number('kapasitas', null, ['class' => 'form-control '.($errors->has('kapasitas') ? 'is-invalid' : ''), 'id' => 'kapasitas']) !!}
            @error('kapasitas')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="keterangan">Keterangan</label>
            {!! Form::text('keterangan', null, ['class' => 'form-control '.($errors->has('keterangan') ? 'is-invalid' : ''), 'id' => 'keterangan']) !!}
            @error('keterangan')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="aktif">Aktif</label>
            {!! Form::select('aktif', [1 => 'Ya',0 => 'Tidak'], null, ['class' => 'form-control '.($errors->has('aktif') ? 'is-invalid' : ''), 'id' => 'aktif']) !!}
            @error('aktif')
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
            var nama_ruangan = $(this).data('nama_ruangan');
            var kapasitas = $(this).data('kapasitas');
            var keterangan = $(this).data('keterangan');
            var aktif = $(this).data('aktif');

            $('[name=nama_ruangan]').val(nama_ruangan);
            $('[name=kapasitas]').val(kapasitas);
            $('[name=keterangan]').val(keterangan);
            $('[name=aktif]').val(aktif);

        });
    </script>
@endpush