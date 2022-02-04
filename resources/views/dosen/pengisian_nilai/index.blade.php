@extends('layouts.app')
@section('title', 'Penilaian')

@section('content')
<x-header>
    Penilaian
</x-header>

<x-card>
    <div class="row">
        <div class="form-group col-lg-3">
            <label for="prodi">Program Studi</label>
            {!! Form::select('prodi', $prodi, null, ['class' => 'form-control', 'id' => 'prodi']) !!}
        </div>
        <div class="form-group col-lg-3">
            <label for="semester">Semester</label>
            {!! Form::select('semester', $semester, null, ['class' => 'form-control', 'id' => 'semester']) !!}
        </div>
    </div>
</x-card>

<x-card-table>
    <x-slot name="title">Kelas Perkuliahan</x-slot>
    
    <x-datatable 
    :route="route('dosen.pengisian_nilai.data_index')" 
    :table="[
        ['title' => 'No.', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => 'false', 'searchable' => 'false', 'width' => '10'],
        ['title' => 'Semester', 'data' => 'nama_semester', 'name' => 'nama_semester', 'classname' => 'text-left'],
        ['title' => 'Program Studi', 'data' => 'nama_program_studi', 'name' => 'nama_program_studi'],
        ['title' => 'Mata Kuliah', 'data' => 'nama_mata_kuliah', 'name' => 'nama_mata_kuliah', 'classname' => 'text-left'],
        ['title' => 'Kelas', 'data' => 'nama_kelas_kuliah', 'name' => 'nama_kelas_kuliah', 'classname' => 'text-left'],
        ['title' => 'Ruang', 'data' => 'ruang', 'name' => 'ruang', 'classname' => 'text-left'],
        ['title' => 'Waktu', 'data' => 'waktu', 'name' => 'waktu'],
        ['title' => 'Penilaian', 'data' => 'action', 'name' => 'action']
    ]"
    :filter="[
        ['data' => 'prodi', 'value' => '$(`#prodi`).val()'],
        ['data' => 'semester', 'value' => '$(`#semester`).val()']
    ]"
    />
</x-card-table>

@endsection

@push('js')
    <script>
        $( document ).ready(function() {
            $(document).on('change','#prodi, #semester',function(){
                table.ajax.reload();
            });
        });
    </script>
@endpush