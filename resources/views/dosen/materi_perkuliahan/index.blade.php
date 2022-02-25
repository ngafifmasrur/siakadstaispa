@extends('layouts.app')
@section('title', $materiText)

@section('content')

<x-header>
    {{ $materiText }}
</x-header>

<x-card-table>
    <x-slot name="title">{{ $materiText }}</x-slot>
    <x-slot name="button">
        <a class="btn btn-app btn-sm btn-primary add-form" data-url="{{ route('dosen.{materi_perkuliahan}.store', ['materi_perkuliahan' => $materi_perkuliahan]) }}" href="#"><i class="fa fa-plus mr-2"></i>Tambah</a>
    </x-slot>

    <x-datatable 
    :route="route('dosen.{materi_perkuliahan}.data_index', ['materi_perkuliahan' => $materi_perkuliahan])" 
    :table="[
        ['title' => 'No.', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => 'false', 'searchable' => 'false', 'width' => '10'],                            
        ['title' => 'Program Studi', 'data' => 'prodi', 'name' => 'prodi','classname' => 'text-left'],
        ['title' => 'Mata Kuliah', 'data' => 'matkul', 'name' => 'matkul', 'classname' => 'text-left'],
        ['title' => 'Judul', 'data' => 'judul', 'name' => 'judul'],
        ['title' => 'Path File', 'data' => 'path_file', 'name' => 'path_file'],
        ['title' => 'Link', 'data' => 'link', 'name' => 'link'],
        ['title' => 'Aksi', 'data' => 'action', 'orderable' => 'false', 'searchable' => 'false'],
    ]"
    />

</x-card-table>

<x-modal.delete/>

<x-modal class="modal-form" id="modal-form">
    <x-slot name="title">{{ $materiText }}</x-slot>
    <x-slot name="modalPosition">modal-dialog-centered</x-slot>
    
    @csrf 
    @method('post')
    
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
            <label for="id_matkul">Mata Kuliah</label>
            {!! Form::select('id_matkul', $matkul, NULL, ['class' => 'form-control '.($errors->has('id_matkul') ? 'is-invalid' : ''), 'id' => 'id_matkul']) !!}
            @error('id_matkul')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="row">
        <div class="form-group col-lg-6">
            <label for="judul">Judul</label>
            {!! Form::text('judul', null, ['class' => 'form-control '.($errors->has('judul') ? 'is-invalid' : ''), 'id' => 'judul']) !!}
            @error('judul')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group col-lg-6">
            <label for="path_file" class="preview">Path File</label>
            <span class="text-danger ml-2">* Maksimal 2MB ( pdf, doc, xls, ppt )</span>
            <div class="custom-file">
                <input type="file" name="path_file" class="custom-file-input {{ $errors->has('path_file') ? 'is-invalid' : '' }}" id="path_file">
                <label class="custom-file-label" for="path_file">Choose file</label>
            </div>
            @error('path_file')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>  
    <div class="row">
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

            $('.preview').html('Path File');
        });

        $(document).on('click', '.btn_edit', function () {
            $('.modal-form').modal('show');
            $('.modal-form form')[0].reset();
            $('.modal-form form').attr('action',  $(this).data('route'));
            $('[name=_method]').val('put');

            $('[name=id_prodi]').val($(this).data('id_prodi'));
            $('[name=id_dosen]').val($(this).data('id_dosen'));
            $('[name=id_matkul]').val($(this).data('id_matkul'));
            $('[name=judul]').val($(this).data('judul'));
            $('[name=link]').val($(this).data('link'));
            $('[name=jenis]').val($(this).data('jenis'));

            if ($(this).data('path_file') != undefined) {
                $('.preview').html(`
                    Path File
                    <a target="_blank" class="btn btn-link text-dark m-0 p-0" href="${$(this).data('path_file')}">Lihat</a>
                `)
                .addClass('d-flex justify-content-between align-items-center m-0 p-0');
            }
        });
        
    </script>
@endpush