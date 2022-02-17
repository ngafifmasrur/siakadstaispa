@extends('layouts.app')
@section('title', 'Ubah Dosen Wali')

@section('content')

<x-header>
    Ubah Dosen Wali
</x-header>

<x-card-table>
    <x-slot name="title">Form Ubah Dosen Wali</x-slot>

    <form action="{{ route('admin.dosen_wali.update', $dosen_wali->id) }}" method="POST">
        @csrf
        <div class="form-group row">
            <label for="id_dosen" class="col-sm-2 col-form-label">Dosen</label>
            <div class="col-sm-10">
                {!! Form::select('id_dosen', $dosen, $dosen_wali->id_dosen, ['class' => 'form-control '.($errors->has('id_dosen') ? 'is-invalid' : ''), 'id' => 'id_dosen']) !!}
                @error('id_dosen')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
        <hr>
        <div class="form-group row">
            <label for="id_dosen" class="col-sm-2 col-form-label">Program Studi</label>
            <div class="col-sm-10">
                {!! Form::select('prodi', $prodi, null, ['class' => 'form-control '.($errors->has('prodi') ? 'is-invalid' : ''), 'id' => 'prodi']) !!}
                @error('prodi')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label for="prodi" class="col-sm-2 col-form-label">Periode Masuk</label>
            <div class="col-sm-10">
                {!! Form::select('periode', $periode, $semester_id, ['class' => 'form-control '.($errors->has('periode') ? 'is-invalid' : ''), 'id' => 'periode']) !!}
                @error('periode')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label for="topik" class="col-sm-2 col-form-label">Mahasiswa </label>
            <div class="col-sm-10">
                <x-datatable 
                :route="route('admin.dosen_wali.mahasiswa_data_index')" 
                :table="[
                    ['title' => 'checkbox', 'data' => 'select_all', 'name' => 'select_all', 'orderable' => 'false', 'searchable' => 'false', 'width' => '10'],                            
                    ['title' => 'NIM', 'data' => 'nim', 'name' => 'nim'],
                    ['title' => 'Nama Mahasiswa', 'data' => 'mahasiswa', 'name' => 'mahasiswa', 'classname' => 'text-left'],
                ]"
                :filter="[
                    ['data' => 'prodi', 'value' => '$(`#prodi`).val()'],
                    ['data' => 'periode', 'value' => '$(`#periode`).val()'],
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


@push('js')
<script>
        $( document ).ready(function() {
            $(document).on('change','#prodi, #periode',function(){
                table.ajax.reload();
            });
        });
</script>
@endpush