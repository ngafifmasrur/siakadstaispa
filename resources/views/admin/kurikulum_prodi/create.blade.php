@extends('layouts.app')
@section('title', 'Kurikulum Prodi')

@section('content')
<x-header>
    Kurikulum Prodi
</x-header>

<x-card>
    <div class="row">
        <div class="form-group col-lg-3">
            <label for="prodi" class="font-weight-bold">Program Studi</label>
            {!! Form::text('prodi', $id_prodi->nama_program_studi, ['class' => 'form-control', 'id' => 'prodi', 'data-targt' => '#id_matkul', 'disabled' => true]) !!}
        </div>
        <div class="form-group col-lg-3">
            <label for="kurikulum" class="font-weight-bold">Kurikulum</label>
            {!! Form::text('kurikulum', $id_kurikulum->nama_kurikulum, ['class' => 'form-control', 'id' => 'id_kurikulum', 'disabled' => true]) !!}
        </div>
    </div>
</x-card>

<x-card>
    <form action="{{ route('admin.kurikulum_prodi.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="form-group col-lg-3">
                <label for="id_matkul" class="font-weight-bold">Mata Kuliah</label>
                {!! Form::select('id_matkul', $matkul, null, ['class' => 'form-control '.($errors->has('id_matkul') ? 'is-invalid' : ''), 'id' => 'id_matkul']) !!}
                @error('id_matkul')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group col-lg-2">
                <label for="id_semester" class="font-weight-bold">Semester</label>
                {!! Form::select('id_semester', $semester, null, ['class' => 'form-control '.($errors->has('id_semester') ? 'is-invalid' : ''), 'id' => 'id_semester']) !!}
                @error('id_semester')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            {{-- <div class="form-group col-lg-2">
                <label for="nilai_minimum" class="font-weight-bold">Nilai Min</label>
                {!! Form::select('nilai_minimum', ['' => 'Pilih Nilai Min', 'A' => 'A', 'B' => 'B', 'C' => 'C', 'D' => 'D', 'E' => 'E'], null, ['class' => 'form-control '.($errors->has('nilai_minimum') ? 'is-invalid' : ''), 'id' => 'nilai_minimum']) !!}
                @error('nilai_minimum')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div> --}}
            <div class="form-group col-lg-2">
                <label for="opsi" class="font-weight-bold d-block">Opsi Tambahan</label>
                <div class="form-check form-check-inline">
                    {!! Form::checkbox('apakah_wajib', 1, 1,['class' => 'form-check-input', 'id' => 'apakah_wajib']) !!}
                    <label class="form-check-label" for="apakah_wajib">
                    MK Wajib
                    </label>
                </div>
                {{-- <div class="form-check form-check-inline">
                    {!! Form::checkbox('mk_paket', 1, 1,['class' => 'form-check-input', 'id' => 'mk_paket']) !!}
                    <label class="form-check-label" for="mk_paket">
                    MK Paket
                    </label>
                </div> --}}
            </div>
            <div class="form-group col-lg-2 my-auto">
                <button class="btn btn-app btn-sm btn-primary" type="submit"><i class="fa fa-plus mr-2"></i>Tambah</button>
            </div>
        </div>
    </form>
</x-card>

<div class="row">
    @foreach ($table_semester as $key => $item)
            <div class="col-lg-6">
                <x-slot name="title">Semester {{ $item }}</x-slot>
                <x-semester-table
                    :title="'Semester '.$item"
                    :id="'semester2'"
                    :route="route('admin.kurikulum_prodi.data_index', [$id_kurikulum->id_kurikulum, $id_prodi->id_prodi])" 
                    :table="[
                        ['title' => 'No.', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => 'false', 'searchable' => 'false', 'width' => '10'],
                        ['title' => 'Kode', 'data' => 'kode_mata_kuliah', 'name' => 'kode_mata_kuliah', 'classname' => 'text-left'],
                        ['title' => 'Nama Mata Kuliah', 'data' => 'nama_mata_kuliah', 'name' => 'nama_mata_kuliah', 'classname' => 'text-left'],
                        ['title' => 'SKS Matkul', 'data' => 'sks_mata_kuliah', 'name' => 'sks_mata_kuliah'],
                        ['title' => 'Wajib', 'data' => 'apakah_wajib', 'name' => 'apakah_wajib'],
                        ['title' => 'Aksi', 'data' => 'action', 'orderable' => 'false', 'searchable' => 'false'],
                    ]"
                />
            </div>
    @endforeach
</div>

<x-modal.delete/>

<x-modal class="modal-form" id="modal-form">
    <x-slot name="title">Kurikulum Prodi</x-slot>
    <x-slot name="modalPosition">modal-dialog-centered</x-slot>
    
    @csrf 
    @method('put')
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="id_matkul">Mata Kuliah</label>
            {!! Form::select('id_matkul', $matkul, null, ['class' => 'form-control '.($errors->has('id_matkul') ? 'is-invalid' : ''), 'id' => 'id_matkul']) !!}
            @error('id_matkul')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="id_semester">Semester</label>
            {!! Form::select('id_semester', $semester, null, ['class' => 'form-control '.($errors->has('id_semester') ? 'is-invalid' : ''), 'id' => 'id_semester']) !!}
            @error('id_semester')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="nilai_minimum" >Nilai Min</label>
            {!! Form::select('nilai_minimum', ['' => 'Pilih Nilai Min', 'A' => 'A', 'B' => 'B', 'C' => 'C', 'D' => 'D', 'E' => 'E'], null, ['class' => 'form-control '.($errors->has('nilai_minimum') ? 'is-invalid' : ''), 'id' => 'nilai_minimum']) !!}
            @error('nilai_minimum')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="opsi" class="d-block">Opsi Tambahan</label>
            <div class="form-check form-check-inline">
                {!! Form::checkbox('mk_wajib', 1, 1,['class' => 'form-check-input', 'id' => 'mk_wajib']) !!}
                <label class="form-check-label" for="mk_wajib">
                MK Wajib
                </label>
            </div>
            <div class="form-check form-check-inline">
                {!! Form::checkbox('mk_paket', 1, 1,['class' => 'form-check-input', 'id' => 'mk_paket']) !!}
                <label class="form-check-label" for="mk_paket">
                MK Paket
                </label>
            </div>
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
        var prodi = $('#prodi').val();
        var tahun_ajaran = $('#tahun_ajaran').val();

        $(document).on('click', '.btn_edit', function () {
            $('.modal-form').modal('show');
            $('.modal-form form')[0].reset();
            $('.modal-form form').attr('action',  $(this).data('route'));
            $('[name=_method]').val('put');
            var id_matkul = $(this).data('id_matkul');
            var id_semester = $(this).data('id_semester');
            var nilai_minimum = $(this).data('nilai_minimum');
            var mk_wajib = $(this).data('mk_wajib');

            $('[name=id_semester]').val(id_semester);
            $('[name=id_matkul]').val(id_matkul);
            $('[name=nilai_minimum]').val(nilai_minimum);
            $('[name=id_semester]').selectpicker("refresh");
            $('[name=id_matkul]').selectpicker("refresh");
            $('[name=nilai_minimum]').selectpicker("refresh");

        });

    </script>
@endpush