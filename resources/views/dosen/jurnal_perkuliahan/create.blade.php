@extends('layouts.app')
@section('title', 'Input Jurnal Kuliah')

@section('content')

<x-header>
    Input Jurnal Kuliah
</x-header>

<x-card-table>
    <x-slot name="title">Form Input Jurnal Kuliah Mata Kuliah: {{ $jadwal->kelas_kuliah->nama_mata_kuliah }}</x-slot>

    <form action="{{ route('dosen.jurnal_perkuliahan.store') }}" method="POST">
        @csrf
        <input type="hidden" name="id_kelas_kuliah" value="{{ $jadwal->id_kelas_kuliah }}">
        <div class="form-group row">
            <label for="nama_matkul" class="col-sm-2 col-form-label">Nama Mata Kuliah</label>
            <div class="col-sm-10">
                {!! Form::text('nama_matkul', $jadwal->kelas_kuliah->nama_mata_kuliah, ['class' => 'form-control '.($errors->has('nama_matkul') ? 'is-invalid' : ''), 'id' => 'nama_matkul', 'readonly' => true]) !!}
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
                {!! Form::text('kode_matkul', $jadwal->kelas_kuliah->kode_mata_kuliah, ['class' => 'form-control '.($errors->has('kode_matkul') ? 'is-invalid' : ''), 'id' => 'kode_matkul', 'readonly' => true]) !!}
                @error('kode_matkul')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label for="pertemuan_ke" class="col-sm-2 col-form-label">Pertemuan Ke</label>
            <div class="col-sm-10">
                {!! Form::number('pertemuan_ke', null, ['class' => 'form-control '.($errors->has('pertemuan_ke') ? 'is-invalid' : ''), 'id' => 'pertemuan_ke', 'max' => 14, 'min' => 0]) !!}
                @error('pertemuan_ke')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label for="status" class="col-sm-2 col-form-label">Status Dosen</label>
            <div class="col-sm-10">
                {!! Form::select('status', ['Hadir' => 'Hadir', 'Ijin' => 'Ijin', 'Alpa' => 'Alpa', 'Sakit' => 'Sakit'] ,null, ['class' => 'form-control '.($errors->has('status') ? 'is-invalid' : ''), 'id' => 'status']) !!}
                @error('status')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label for="tanggal_pelaksanaan" class="col-sm-2 col-form-label">Tanggal Pelaksanaan <span class="text-danger">*</span></label>
            <div class="col-sm-10">
                {!! Form::text('tanggal_pelaksanaan', null, ['class' => 'form-control fc-datepicker '.($errors->has('tanggal_pelaksanaan') ? 'is-invalid' : ''), 'id' => 'tanggal_pelaksanaan', 'placeholder' => 'MM/DD/YYYY', 'autocomplete' => 'off']) !!}
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
                {!! Form::textarea('topik', null, ['class' => 'form-control '.($errors->has('topik') ? 'is-invalid' : ''), 'id' => 'topik', 'rows' => 5]) !!}
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
                :route="route('dosen.jurnal_perkuliahan.mahasiswa_data_index', $jadwal->id_kelas_kuliah)" 
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
		<!-- Date Picker css-->
		<link href="{{ asset('sparic/plugins/spectrum-date-picker/spectrum.css') }}" rel="stylesheet" />

    <style>
        .form-group {
            display: flex!important;
        }
    </style>
@endpush

@push('js')
		<!-- Datepicker js -->
		<script src="{{ asset('sparic/plugins/spectrum-date-picker/spectrum.js') }}"></script>
		<script src="{{ asset('sparic/plugins/spectrum-date-picker/jquery-ui.js') }}"></script>
		<script src="{{ asset('sparic/plugins/input-mask/jquery.maskedinput.js') }}"></script>
        <script src="{{ asset('sparic/js/form-elements.js') }}"></script>
@endpush
