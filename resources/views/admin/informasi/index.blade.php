@extends('layouts.app')
@section('title', 'Informasi')

@section('content')
<x-header>
    Informasi
</x-header>

<x-card-table>
    <x-slot name="title">Data Informasi</x-slot>
    <x-slot name="button">
        <a class="btn btn-app btn-sm btn-primary add-form" data-url="{{ route('admin.informasi.store') }}" href="#"><i class="fa fa-plus mr-2"></i>Tambah</a>
    </x-slot>

    <x-datatable 
    :route="route('admin.informasi.data_index')" 
    :table="[
        ['title' => 'No.', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => 'false', 'searchable' => 'false', 'width' => '10'],
        ['title' => 'Judul', 'data' => 'judul', 'name' => 'judul', 'classname' => 'text-left'],
        ['title' => 'Status', 'data' => 'status', 'name' => 'status', 'classname' => 'text-left'],
        ['title' => 'Aksi', 'data' => 'action', 'orderable' => 'false', 'searchable' => 'false'],
    ]"
    />

</x-card-table>

<x-modal.delete/>

<x-modal class="modal-form" id="modal-form">
    <x-slot name="title">Informasi</x-slot>
    <x-slot name="modalPosition">modal-dialog-centered</x-slot>

    @csrf 
    @method('post')
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="judul">Judul</label>
            {!! Form::text('judul', null, ['class' => 'form-control '.($errors->has('judul') ? 'is-invalid' : ''), 'id' => 'judul']) !!}
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="informasi">Informasi</label>
            {!! Form::textarea('informasi', null, ['class' => 'form-control '.($errors->has('informasi') ? 'is-invalid' : ''), 'id' => 'informasi', 'rows' => 5]) !!}
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-6">
            <label for="status">Status</label><br>
            {!! Form::select('status', array(1 => 'Publish', 0 => 'Unpublish') , ['class' => 'form-control '.($errors->has('status') ? 'is-invalid' : ''), 'id' => 'status']); !!}
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
    var konten = document.getElementById("informasi");
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
            var informasi = $(this).data('informasi');
            var status = $(this).data('status');

            $('[name=judul]').val(judul);
            $('[name=status]').val(status);

            editor = CKEDITOR.instances.informasi;
            editor.setData(informasi);

        });
    </script>
@endpush