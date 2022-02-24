@extends('layouts.app')
@section('title', 'Konfigurasi Menu')

@push('css')
<style>
    .list-group-item {
        display: flex;
        align-items: center;
    }

    .highlight {
        background: #f7e7d3;
        min-height: 30px;
        list-style-type: none;
    }

    .handle {
        min-width: 18px;
        height: 15px;
        display: inline-block;
        cursor: move;
        margin-right: 10px;
    }
</style>
<link href="https://code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css"/>

@endpush

@section('content')
<x-header>
    Konfigurasi Menu
</x-header>

<x-card-table>
    <x-slot name="title">Konfigurasi Menu</x-slot>
    <x-slot name="button">
        <a class="btn btn-app btn-sm btn-primary add-form" data-url="{{ route('admin.konfigurasi_menu.store') }}" href="#"><i class="fa fa-plus mr-2"></i>Tambah</a>
    </x-slot>

    <ul class="sort_menu list-group">
        @forelse ($data as $row)
        <li class="list-group-item" data-id="{{$row->id}}">
            <span class="handle text-primary"><i class="fa fa-bars"></i></span> {{$row->judul}} <span data-link="{{ $row->link }}" data-judul="{{ $row->judul }}" data-route="{{ route('admin.konfigurasi_menu.update', $row->id) }}" class="btn_edit"><i class="fa fa-edit ml-2"></i></span></li>
        @empty
            Tidak ada data
        @endforelse
    </ul>

</x-card-table>

<x-modal.delete/>

<x-modal class="modal-form" id="modal-form">
    <x-slot name="title">Menu</x-slot>
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
            <label for="link">Link / URL</label>
            {!! Form::text('link', null, ['class' => 'form-control '.($errors->has('link') ? 'is-invalid' : ''), 'id' => 'link', 'placeholder' => 'ex: /home']) !!}
        </div>
    </div>

    <x-slot name="footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </x-slot>
</x-modal>
@endsection

@push('js')
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
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
            var link = $(this).data('link');

            $('[name=judul]').val(judul);
            $('[name=link]').val(link);

        });

    $(document).ready(function(){
        
        function updateToDatabase(idString){
        $.ajaxSetup({ headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'}});
            
        $.ajax({
            url:'{{url('/admin/konfigurasi_menu/updateOrder')}}',
            method:'POST',
            data:{ids:idString},
            success:function(){
                $.growl.notice({ duration: 3000, title: "Berhasil disimpan!",message: 'Urutan menu diubah' });
                    //do whatever after success
            }
        })
        }

        var target = $('.sort_menu');
        target.sortable({
            handle: '.handle',
            placeholder: 'highlight',
            axis: "y",
            update: function (e, ui){
            var sortData = target.sortable('toArray',{ attribute: 'data-id'})
            updateToDatabase(sortData.join(','))
            }
        })
        
    })
    </script>
@endpush