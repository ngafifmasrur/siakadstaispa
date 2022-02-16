@extends('layouts.app')
@section('title', 'Berita')

@section('content')
<x-header>
    Berita
</x-header>

<x-card-table>
    <x-slot name="title">Data Berita</x-slot>
    <x-slot name="button">
        <a class="btn btn-app btn-sm btn-primary add-form" data-url="{{ route('admin.berita.store') }}" href="#"><i class="fa fa-plus mr-2"></i>Tambah</a>
    </x-slot>

    <x-datatable 
    :route="route('admin.berita.data_index')" 
    :table="[
        ['title' => 'No.', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => 'false', 'searchable' => 'false', 'width' => '10'],
        ['title' => 'Judul', 'data' => 'judul', 'name' => 'judul', 'classname' => 'text-left'],
        ['title' => 'Hits', 'data' => 'hits', 'name' => 'hits', 'classname' => 'text-left'],
        ['title' => 'Publish', 'data' => 'publish', 'name' => 'publish', 'classname' => 'text-left'],
        ['title' => 'Aksi', 'data' => 'action', 'orderable' => 'false', 'searchable' => 'false'],
    ]"
    />

</x-card-table>

<x-modal.delete/>

<x-modal class="modal-form" id="modal-form">
    <x-slot name="title">Berita</x-slot>
    <x-slot name="modalPosition">modal-dialog-centered</x-slot>

    @csrf 
    @method('post')
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="variable">Judul</label>
            {!! Form::text('judul', null, ['class' => 'form-control '.($errors->has('judul') ? 'is-invalid' : ''), 'id' => 'judul']) !!}
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="value">Isi</label>
            {!! Form::textarea('isi', null, ['class' => 'form-control '.($errors->has('isi') ? 'is-invalid' : ''), 'id' => 'isi', 'rows' => 5]) !!}
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-6">
            <label for="publish">Publish</label><br>
            {!! Form::select('publish', array('1' => 'Publish', '0' => 'Unpublish') , ['class' => 'form-control '.($errors->has('publish') ? 'is-invalid' : ''), 'id' => 'publish']); !!}
        </div>
    </div>

    <div id="gambars"></div>
    
    <div class="form-group row mt-2">    
        <div class="form-group col-lg-12">
            <label for="publish">Gambar</label><br>
            <input type="file" name="gambar" class="form-controll">
            <small id="emailHelp" class="form-text text-muted">tipe : jpg , jpeg , png | max size : 5MB</small>
        </div>
    </div>

    <x-slot name="footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </x-slot>
</x-modal>
@endsection

@push('js')
    <script src="{{asset('ckeditor/ckeditor.js')}}"></script>
    <script>
    var konten = document.getElementById("isi");
        CKEDITOR.replace(konten,{
        language:'en-gb'
    });
    CKEDITOR.config.allowedContent = true;
    </script>
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
            
            var judul = $(this).data('judul');
            var isi = $(this).data('isi');
            var publish = $(this).data('publish');
            var gambar = $(this).data('gambar');

            $('[name=judul]').val(judul);
            $('[name=publish]').val(publish);

            editor = CKEDITOR.instances.isi;
            editor.setData(isi);

            $("#gambars").html("<img src='"+gambar+"' class='img-fluid' width='300'>");

        });
    </script>
@endpush