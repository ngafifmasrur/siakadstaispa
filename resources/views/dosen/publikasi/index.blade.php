@extends('layouts.app')
@section('title', 'Publikasi')

@section('content')

<x-header>
    Publikasi
</x-header>

<x-card-table>
    <x-slot name="title">Publikasi</x-slot>
    <x-slot name="button">
        <a class="btn btn-app btn-sm btn-primary add-form" data-url="{{ route('dosen.publikasi.store') }}" href="#"><i class="fa fa-plus mr-2"></i>Tambah</a>
    </x-slot>

    <x-datatable 
    :route="route('dosen.publikasi.data_index')" 
    :table="[
        ['title' => 'No.', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => 'false', 'searchable' => 'false', 'width' => '10'],                            
        ['title' => 'Program Studi', 'data' => 'prodi', 'name' => 'prodi','classname' => 'text-left'],
        ['title' => 'Sifat Publikasi', 'data' => 'sifat_publikasi', 'name' => 'sifat_publikasi', 'classname' => 'text-left'],
        ['title' => 'Tahun', 'data' => 'tahun', 'name' => 'tahun', 'classname' => 'text-left'],
        ['title' => 'Judul', 'data' => 'judul', 'name' => 'judul'],
        ['title' => 'Tempat Publikasi', 'data' => 'tempat_publikasi', 'name' => 'tempat_publikasi'],
        ['title' => 'Link', 'data' => 'link', 'name' => 'link'],
        ['title' => 'Aksi', 'data' => 'action', 'orderable' => 'false', 'searchable' => 'false'],
    ]"
    />

</x-card-table>

<x-modal.delete/>

<x-modal class="modal-form" id="modal-form">
    <x-slot name="title">Publikasi</x-slot>
    <x-slot name="modalPosition">modal-dialog-centered</x-slot>
    
    @csrf 
    @method('post')
    @php
        $years = [];
        for ($year=2000; $year <= date('Y'); $year++) $years[$year] = $year;
    @endphp

    <div class="row">
        <div class="form-group col-lg-6">
            <label for="id_prodi">Program Studi</label>
            {!! Form::select('id_prodi', $prodi, NULL, ['class' => 'form-control '.($errors->has('id_prodi') ? 'is-invalid' : ''), 'id' => 'id_prodi']) !!}
            @error('id_prodi')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group col-lg-6">
            <label for="sifat_publikasi">Sifat Publikasi</label>
            {!! Form::text('sifat_publikasi', null, ['class' => 'form-control '.($errors->has('sifat_publikasi') ? 'is-invalid' : ''), 'id' => 'sifat_publikasi']) !!}
            @error('sifat_publikasi')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="row">
        <div class="form-group col-lg-6">
            <label for="tahun">Tahun</label>
            {!! Form::select('tahun', $years, date('Y'), ['class' => 'form-control '.($errors->has('tahun') ? 'is-invalid' : ''), 'id' => 'tahun']) !!}
            @error('tahun')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group col-lg-6">
            <label for="judul">Judul</label>
            {!! Form::text('judul', null, ['class' => 'form-control '.($errors->has('judul') ? 'is-invalid' : ''), 'id' => 'judul']) !!}
            @error('judul')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>  
    <div class="row">
        <div class="form-group col-lg-6">
            <label for="tempat_publikasi">Tempat Publikasi</label>
            {!! Form::text('tempat_publikasi', null, ['class' => 'form-control '.($errors->has('tempat_publikasi') ? 'is-invalid' : ''), 'id' => 'tempat_publikasi']) !!}
            @error('tempat_publikasi')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group col-lg-6">
            <label for="link">Link</label>
            {!! Form::text('link', null, ['class' => 'form-control '.($errors->has('link') ? 'is-invalid' : ''), 'id' => 'link']) !!}
            @error('link')
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

            $('[name=id_prodi]').val($(this).data('id_prodi'));
            $('[name=id_dosen]').val($(this).data('id_dosen'));
            $('[name=sifat_publikasi]').val($(this).data('sifat_publikasi'));
            $('[name=tahun]').val($(this).data('tahun'));
            $('[name=judul]').val($(this).data('judul'));
            $('[name=tempat_publikasi]').val($(this).data('tempat_publikasi'));
            $('[name=link]').val($(this).data('link'));
        });
        
    </script>
@endpush