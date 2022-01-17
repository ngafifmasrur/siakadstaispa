@extends('layouts.app')
@section('title', 'Penelitian')

@section('content')

<x-header>
    Penelitian
</x-header>

<x-card-table>
    <x-slot name="title">Penelitian</x-slot>
    <x-slot name="button">
        <a class="btn btn-app btn-sm btn-primary add-form" data-url="{{ route('dosen.penelitian.store') }}" href="#"><i class="fa fa-plus mr-2"></i>Tambah</a>
    </x-slot>

    <x-datatable 
    :route="route('dosen.penelitian.data_index')" 
    :table="[
        ['title' => 'No.', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => 'false', 'searchable' => 'false', 'width' => '10'],                            
        ['title' => 'Program Studi', 'data' => 'prodi', 'name' => 'prodi','classname' => 'text-left'],
        ['title' => 'Ketua', 'data' => 'ketua', 'name' => 'ketua', 'classname' => 'text-left'],
        ['title' => 'Anggota', 'data' => 'anggota', 'name' => 'anggota', 'classname' => 'text-left'],
        ['title' => 'Sumber Dana', 'data' => 'sumber_dana', 'name' => 'sumber_dana'],
        ['title' => 'Nominal', 'data' => 'nominal', 'name' => 'nominal'],
        ['title' => 'Tahun', 'data' => 'tahun', 'name' => 'tahun'],
        ['title' => 'Judul Penelitian', 'data' => 'judul_penelitian', 'name' => 'judul_penelitian'],
        ['title' => 'Link', 'data' => 'link', 'name' => 'link', 'orderable' => 'false'],
        ['title' => 'Aksi', 'data' => 'action', 'orderable' => 'false', 'searchable' => 'false'],
    ]"
    />

</x-card-table>

<x-modal.delete/>

<x-modal class="modal-form" id="modal-form">
    <x-slot name="title">Penelitian</x-slot>
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
            <label for="ketua">Ketua</label>
            {!! Form::text('ketua', null, ['class' => 'form-control '.($errors->has('ketua') ? 'is-invalid' : ''), 'id' => 'ketua']) !!}
            @error('ketua')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="row">
        <div class="form-group col-lg-6">
            <label for="anggota_1">Anggota 1</label>
            {!! Form::text('anggota_1', null, ['class' => 'form-control '.($errors->has('anggota_1') ? 'is-invalid' : ''), 'id' => 'anggota_1']) !!}
            @error('anggota_1')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group col-lg-6">
            <label for="anggota_2">Anggota 2</label>
            {!! Form::text('anggota_2', null, ['class' => 'form-control '.($errors->has('anggota_2') ? 'is-invalid' : ''), 'id' => 'anggota_2']) !!}
            @error('anggota_2')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="row">
        <div class="form-group col-lg-6">
            <label for="anggota_3">Anggota 3</label>
            {!! Form::text('anggota_3', null, ['class' => 'form-control '.($errors->has('anggota_3') ? 'is-invalid' : ''), 'id' => 'anggota_3']) !!}
            @error('anggota_3')
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
            <label for="judul_penelitian">Judul Penelitian</label>
            {!! Form::text('judul_penelitian', null, ['class' => 'form-control '.($errors->has('judul_penelitian') ? 'is-invalid' : ''), 'id' => 'judul_penelitian']) !!}
            @error('judul_penelitian')
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
            $('[name=ketua]').val($(this).data('ketua'));
            $('[name=anggota_1]').val($(this).data('anggota_1'));
            $('[name=anggota_2]').val($(this).data('anggota_2'));
            $('[name=anggota_3]').val($(this).data('anggota_3'));
            $('[name=sumber_dana]').val($(this).data('sumber_dana'));
            $('[name=nominal]').val($(this).data('nominal'));
            $('[name=tahun]').val($(this).data('tahun'));
            $('[name=judul_penelitian]').val($(this).data('judul_penelitian'));
            $('[name=link]').val($(this).data('link'));
        });
        
    </script>
@endpush