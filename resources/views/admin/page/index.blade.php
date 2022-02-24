@extends('layouts.app')
@section('title', 'Page')

@section('content')
<x-header>
    Page
</x-header>

<x-card-table>
    <x-slot name="title">Data Pages</x-slot>
    <x-slot name="button">
        <a class="btn btn-app btn-sm btn-primary" href="{{ route('admin.page.create') }}"><i class="fa fa-plus mr-2"></i>Tambah</a>
    </x-slot>

    <x-datatable 
    :route="route('admin.page.data_index')" 
    :table="[
        ['title' => 'No.', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => 'false', 'searchable' => 'false', 'width' => '10'],
        ['title' => 'Judul', 'data' => 'judul', 'name' => 'judul', 'classname' => 'text-left'],
        ['title' => 'Link', 'data' => 'link', 'name' => 'link'],
        ['title' => 'Status', 'data' => 'status', 'name' => 'status'],
        ['title' => 'Aksi', 'data' => 'action', 'orderable' => 'false', 'searchable' => 'false'],
    ]"
    />

</x-card-table>

<x-modal.delete/>
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