@extends('layouts.app')
@section('title', 'Kuesioner')

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
    Kuesioner
</x-header>

<x-card-table>
    <x-slot name="title">Kuesioner</x-slot>
    <x-slot name="button">
        <a class="btn btn-app btn-sm btn-primary add-form" data-url="{{ route('admin.kuesioner.store') }}" href="#"><i class="fa fa-plus mr-2"></i>Tambah</a>
    </x-slot>

    <x-datatable 
    :route="route('admin.kuesioner.data_index')" 
    :table="[
        ['title' => 'No.', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => 'false', 'searchable' => 'false', 'width' => '10'],
        ['title' => 'Kuesioner', 'data' => 'kuesioner', 'name' => 'kuesioner', 'classname' => 'text-left'],
        ['title' => 'Jenis', 'data' => 'jenis', 'name' => 'jenis', 'classname' => 'text-left'],
        ['title' => 'Status', 'data' => 'status', 'name' => 'status', 'classname' => 'text-left'],
        ['title' => 'Aksi', 'data' => 'action', 'orderable' => 'false', 'searchable' => 'false'],
    ]"
    />

</x-card-table>

<x-modal.delete/>

<x-modal class="modal-form" id="modal-form">
    <x-slot name="title">Menu</x-slot>
    <x-slot name="modalPosition">modal-dialog-centered</x-slot>

    @csrf 
    @method('post')
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="kuesioner">Kuesioner</label>
            {!! Form::text('kuesioner', null, ['class' => 'form-control '.($errors->has('kuesioner') ? 'is-invalid' : ''), 'id' => 'kuesioner']) !!}
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="jenis">Jenis</label>
            <select name="jenis" id="jenis" class="jenis form-control">
                <option value="dosen">Dosen</option>
            </select>
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="status" class="status">Status</label>
            <select name="status" id="status" class="status form-control">
                <option value="1">Published</option>
                <option value="0">Non Published</option>
            </select>
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
            
            var kuesioner = $(this).data('kuesioner');
            var jenis = $(this).data('jenis');
            var status = $(this).data('status');

            $('[name=kuesioner]').val(kuesioner);
            $('[name=jenis]').val(jenis);
            $('[name=status]').val(status);

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