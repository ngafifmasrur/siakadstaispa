@extends('layouts.app')
@section('title', 'Input Jurnal Kuliah')

@section('content')

<x-header>
    Edit Jurnal Kuliah
</x-header>

<x-card-table>
    <x-slot name="title">Form Edit Jurnal Kuliah Mata Kuliah: {{ $jadwal->matkul->matkul->nama_mata_kuliah }}</x-slot>

    <form action="{{ route('dosen.jurnal_perkuliahan.update', $jurnal_perkuliahan->id) }}" method="POST">
        @csrf @method('PUT')
        <input type="hidden" name="id_jadwal" value="{{ $jadwal->id }}">
        <div class="form-group row">
            <label for="nama_matkul" class="col-sm-2 col-form-label">Nama Mata Kuliah</label>
            <div class="col-sm-10">
                {!! Form::text('nama_matkul', $jadwal->matkul->matkul->nama_mata_kuliah, ['class' => 'form-control '.($errors->has('nama_matkul') ? 'is-invalid' : ''), 'id' => 'nama_matkul', 'readonly' => true]) !!}
                @error('nama_matkul')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label for="kode_matkul" class="col-sm-2 col-form-label">Kode Mata Kuliah</label>
            <div class="col-sm-10">
                {!! Form::text('kode_matkul', $jadwal->matkul->matkul->kode_mata_kuliah, ['class' => 'form-control '.($errors->has('kode_matkul') ? 'is-invalid' : ''), 'id' => 'kode_matkul', 'readonly' => true]) !!}
                @error('kode_matkul')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label for="tanggal_pelaksanaan" class="col-sm-2 col-form-label">Tanggal Pelaksanaan <span class="text-danger">*</span></label>
            <div class="col-sm-10">
                {!! Form::date('tanggal_pelaksanaan', $jurnal_perkuliahan->tanggal_pelaksanaan, ['class' => 'form-control '.($errors->has('tanggal_pelaksanaan') ? 'is-invalid' : ''), 'id' => 'tanggal_pelaksanaan']) !!}
                @error('tanggal_pelaksanaan')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label for="topik" class="col-sm-2 col-form-label">Topik/Pokok Pembahasan </label>
            <div class="col-sm-10">
                {!! Form::textarea('topik', $jurnal_perkuliahan->topik, ['class' => 'form-control '.($errors->has('topik') ? 'is-invalid' : ''), 'id' => 'topik', 'rows' => 5]) !!}
                @error('topik')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label for="topik" class="col-sm-2 col-form-label">Absensi Mahasiswa </label>
            <div class="col-sm-10">
                <x-datatable 
                :route="route('dosen.jurnal_perkuliahan.mahasiswa_data_index', [ 'id_jadwal' => $jadwal->id, 'id_jurnal' => $jurnal_perkuliahan->id])" 
                :table="[
                    ['title' => 'No.', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => 'false', 'searchable' => 'false', 'width' => '10'],
                    ['title' => 'NIM', 'data' => 'nim', 'name' => 'nim'],
                    ['title' => 'Nama Mahasiswa', 'data' => 'mahasiswa', 'name' => 'mahasiswa', 'classname' => 'text-left'],
                    ['title' => 'Hadir', 'data' => 'hadir', 'name' => 'hadir', 'orderable' => 'false'],
                    ['title' => 'Sakit', 'data' => 'sakit', 'name' => 'sakit', 'orderable' => 'false'],
                    ['title' => 'Ijin', 'data' => 'ijin', 'name' => 'ijin', 'orderable' => 'false'],
                    ['title' => 'Alpa', 'data' => 'alpa', 'name' => 'alpa', 'orderable' => 'false'],

                ]"
                />
            </div>
        </div>
        <button class="float-right btn btn-primary" type="submit">Simpan</button>

    </form>

</x-card-table>
@endsection

@push('css')
    <style>
        .form-group {
            display: flex!important;
        }
    </style>
@endpush