@extends('layouts.app')
@section('title', 'Pengabdian')

@section('content')

<x-header>
    Pengabdian
</x-header>

<x-card-table>
    <x-slot name="title">Pengabdian</x-slot>
    <x-slot name="button">
        <a class="btn btn-app btn-sm btn-primary add-form" data-url="{{ route('dosen.pengabdian.store') }}" href="#"><i class="fa fa-plus mr-2"></i>Tambah</a>
    </x-slot>

    <x-datatable 
    :route="route('dosen.pengabdian.data_index')" 
    :table="[
        ['title' => 'No.', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => 'false', 'searchable' => 'false', 'width' => '10'],                            
        ['title' => 'Program Studi', 'data' => 'prodi', 'name' => 'prodi','classname' => 'text-left'],
        ['title' => 'Ketua', 'data' => 'sumber_dana', 'name' => 'sumber_dana', 'classname' => 'text-left'],
        ['title' => 'Anggota', 'data' => 'nominal', 'name' => 'nominal', 'classname' => 'text-left'],
        ['title' => 'Sumber Dana', 'data' => 'tahun', 'name' => 'tahun'],
        ['title' => 'Nominal', 'data' => 'judul_pengabdian', 'name' => 'judul_pengabdian'],
        ['title' => 'Aksi', 'data' => 'action', 'orderable' => 'false', 'searchable' => 'false'],
    ]"
    />

</x-card-table>

<x-modal.delete/>

<x-modal class="modal-form" id="modal-form">
    <x-slot name="title">Pengabdian</x-slot>
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
            <label for="sumber_dana">Sumber Dana</label>
            {!! Form::text('sumber_dana', null, ['class' => 'form-control '.($errors->has('sumber_dana') ? 'is-invalid' : ''), 'id' => 'sumber_dana']) !!}
            @error('sumber_dana')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="row">
        <div class="form-group col-lg-6">
            <label for="nominal">Nominal</label>
            {!! Form::number('nominal', null, ['class' => 'form-control '.($errors->has('nominal') ? 'is-invalid' : ''), 'id' => 'nominal']) !!}
            @error('nominal')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group col-lg-6">
            <label for="tahun">Tahun</label>
            {!! Form::select('tahun', $years, date('Y'), ['class' => 'form-control '.($errors->has('tahun') ? 'is-invalid' : ''), 'id' => 'tahun']) !!}
            @error('tahun')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="row">
        <div class="form-group col-lg-6">
            <label for="judul_pengabdian">Judul Pengabdian</label>
            {!! Form::text('judul_pengabdian', null, ['class' => 'form-control '.($errors->has('judul_pengabdian') ? 'is-invalid' : ''), 'id' => 'judul_pengabdian']) !!}
            @error('judul_pengabdian')
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
            $('[name=sumber_dana]').val($(this).data('sumber_dana'));
            $('[name=nominal]').val($(this).data('nominal'));
            $('[name=tahun]').val($(this).data('tahun'));
            $('[name=judul_pengabdian]').val($(this).data('judul_pengabdian'));
        });
        
    </script>
@endpush