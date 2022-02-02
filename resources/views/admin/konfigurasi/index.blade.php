@extends('layouts.app')
@section('title', 'Konfigurasi')

@section('content')
<x-header>
    Konfigurasi
</x-header>

<x-card-table>
    <x-slot name="title">Data Konfigurasi</x-slot>
    <x-slot name="button">
        <a class="btn btn-app btn-sm btn-primary add-form" data-url="{{ route('admin.konfigurasi.store') }}" href="#"><i class="fa fa-plus mr-2"></i>Tambah</a>
    </x-slot>

    <x-datatable 
    :route="route('admin.konfigurasi.data_index')" 
    :table="[
        ['title' => 'No.', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => 'false', 'searchable' => 'false', 'width' => '10'],
        ['title' => 'Variable', 'data' => 'variable', 'name' => 'variable', 'classname' => 'text-left'],
        ['title' => 'Value', 'data' => 'value', 'name' => 'value', 'classname' => 'text-left'],
        ['title' => 'Aksi', 'data' => 'action', 'orderable' => 'false', 'searchable' => 'false'],
    ]"
    />

</x-card-table>

<x-modal.delete/>

<x-modal class="modal-form" id="modal-form">
    <x-slot name="title">Konfigurasi</x-slot>
    <x-slot name="modalPosition">modal-dialog-centered</x-slot>
    
    @csrf 
    @method('post')
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="variable">Variable</label>
            {!! Form::text('variable', null, ['class' => 'form-control', 'id' => 'variable']) !!}
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="value">Value</label>
            {!! Form::text('value', null, ['class' => 'form-control', 'id' => 'value']) !!}
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
            
            var variable = $(this).data('variable');
            var value = $(this).data('value');

            $('[name=variable]').val(variable);
            $('[name=value]').val(value);

        });
    </script>
@endpush