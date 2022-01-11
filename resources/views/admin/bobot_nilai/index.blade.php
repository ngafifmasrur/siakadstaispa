@extends('layouts.app')
@section('title', 'Bobot Nilai')

@section('content')
<x-header>
    Bobot Nilai
</x-header>

<x-card-table>
    <x-slot name="title">Data Bobot Nilai</x-slot>
    <x-slot name="button">
        <a class="btn btn-app btn-sm btn-primary add-form" data-url="{{ route('admin.bobot_nilai.store') }}" href="#"><i class="fa fa-plus mr-2"></i>Tambah</a>
    </x-slot>
    
    <x-datatable 
    :route="route('admin.bobot_nilai.data_index')" 
    :table="[
        ['title' => 'No.', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => 'false', 'searchable' => 'false', 'width' => '10'],                            
        ['title' => 'Program Studi', 'data' => 'prodi', 'name' => 'prodi', 'classname' => 'text-left'],
        ['title' => 'Nilai Huruf', 'data' => 'nilai_huruf', 'name' => 'nilai_huruf'],
        ['title' => 'Nilai Indeks', 'data' => 'nilai_indeks', 'name' => 'nilai_indeks'],
        ['title' => 'Bobot Minimum', 'data' => 'bobot_minimum', 'name' => 'bobot_minimum'],
        ['title' => 'Bobot Maksimum', 'data' => 'bobot_maksimum', 'name' => 'bobot_maksimum'],
        ['title' => 'Tanggal Mulai Efektif', 'data' => 'tanggal_mulai_efektif', 'name' => 'tanggal_mulai_efektif'],
        ['title' => 'Tanggal Selsai Efektif', 'data' => 'tanggal_selesai_efektif', 'name' => 'tanggal_selesai_efektif'],
        ['title' => 'Aksi', 'data' => 'action', 'orderable' => 'false', 'searchable' => 'false'],
    ]"
    />
</x-card-table>

<x-modal.delete/>

<x-modal class="modal-form" id="modal-form">
    <x-slot name="title">Bobot Nilai</x-slot>
    <x-slot name="modalPosition">modal-dialog-centered</x-slot>
    
    @csrf 
    @method('post')
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="id_prodi">Program Studi</label>
            {!! Form::select('id_prodi', $prodi, null, ['class' => 'form-control '.($errors->has('id_prodi') ? 'is-invalid' : ''), 'id' => 'id_prodi']) !!}
            @error('id_prodi')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="nilai_huruf">Nilai Huruf</label>
            {!! Form::text('nilai_huruf', null, ['class' => 'form-control '.($errors->has('nilai_huruf') ? 'is-invalid' : ''), 'id' => 'nilai_huruf']) !!}
            @error('nilai_huruf')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="nilai_indeks">Nilai Indeks</label>
            {!! Form::number('nilai_indeks', null, ['class' => 'form-control '.($errors->has('nilai_indeks') ? 'is-invalid' : ''), 'id' => 'nilai_indeks']) !!}
            @error('nilai_indeks')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="bobot_minimum">Bobot Minimum</label>
            {!! Form::number('bobot_minimum', null, ['class' => 'form-control '.($errors->has('bobot_minimum') ? 'is-invalid' : ''), 'id' => 'bobot_minimum']) !!}
            @error('bobot_minimum')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="bobot_maksimum">Bobot Maksimum</label>
            {!! Form::number('bobot_maksimum', null, ['class' => 'form-control '.($errors->has('bobot_maksimum') ? 'is-invalid' : ''), 'id' => 'bobot_maksimum']) !!}
            @error('bobot_maksimum')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="tanggal_mulai_efektif">Tanggal Mulai Efektif</label>
            {!! Form::date('tanggal_mulai_efektif', null, ['class' => 'form-control '.($errors->has('tanggal_mulai_efektif') ? 'is-invalid' : ''), 'id' => 'tanggal_mulai_efektif']) !!}
            @error('tanggal_mulai_efektif')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="tanggal_selesai_efektif">Tanggal Selesai Efektif</label>
            {!! Form::date('tanggal_selesai_efektif', null, ['class' => 'form-control '.($errors->has('tanggal_selesai_efektif') ? 'is-invalid' : ''), 'id' => 'tanggal_selesai_efektif']) !!}
            @error('tanggal_selesai_efektif')
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

<x-modal class="edit-form" id="modal-form">
    <x-slot name="title">Mata Kuliah</x-slot>
    <x-slot name="modalPosition">modal-dialog-centered</x-slot>
    @csrf
    @method('put')
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="id_prodi">Program Studi</label>
            {!! Form::select('id_prodi', $prodi, null, ['class' => 'form-control', 'id' => 'id_prodi']) !!}
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="nilai_huruf">Nilai Huruf</label>
            {!! Form::text('nilai_huruf', null, ['class' => 'form-control', 'id' => 'nilai_huruf']) !!}
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="nilai_indeks">Nilai Indeks</label>
            {!! Form::number('nilai_indeks', null, ['class' => 'form-control', 'id' => 'nilai_indeks']) !!}
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="bobot_minimum">Bobot Minimum</label>
            {!! Form::number('bobot_minimum', null, ['class' => 'form-control', 'id' => 'bobot_minimum']) !!}
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="bobot_maksimum">Bobot Maksimum</label>
            {!! Form::number('bobot_maksimum', null, ['class' => 'form-control', 'id' => 'bobot_maksimum']) !!}
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="tanggal_mulai_efektif">Tanggal Mulai Efektif</label>
            {!! Form::date('tanggal_mulai_efektif', null, ['class' => 'form-control', 'id' => 'tanggal_mulai_efektif']) !!}
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="tanggal_selesai_efektif">Tanggal Selesai Efektif</label>
            {!! Form::date('tanggal_selesai_efektif', null, ['class' => 'form-control', 'id' => 'tanggal_selesai_efektif']) !!}
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
            var id_prodi = $(this).data('prodi');
            var nilai_huruf = $(this).data('nilai_huruf');
            var nilai_indeks = $(this).data('nilai_indeks');
            var bobot_minimum = $(this).data('bobot_minimum');
            var bobot_maksimum = $(this).data('bobot_maksimum');
            var tanggal_mulai = $(this).data('tanggal_mulai');
            var tanggal_selesai = $(this).data('tanggal_selesai');

            $('[name=id_prodi]').val(id_prodi);
            $('[name=nilai_huruf]').val(nilai_huruf);
            $('[name=nilai_indeks]').val(nilai_indeks);
            $('[name=bobot_minimum]').val(bobot_minimum);
            $('[name=bobot_maksimum]').val(bobot_maksimum);
            $('[name=tanggal_mulai_efektif]').val(tanggal_mulai);
            $('[name=tanggal_selesai_efektif]').val(tanggal_selesai);

        });
    </script>
@endpush