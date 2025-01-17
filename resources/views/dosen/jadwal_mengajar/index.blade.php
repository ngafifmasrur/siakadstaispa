@extends('layouts.app')
@section('title', 'Jadwal Mengajar')

@section('content')
<x-header>
    Jadwal Mengajar
</x-header>

<x-card>
    <div class="row">
        <div class="form-group col-lg-3">
            <label for="prodi">Program Studi</label>
            {!! Form::select('prodi', $prodi, null, ['class' => 'form-control', 'id' => 'prodi']) !!}
        </div>
    </div>
</x-card>

<x-card-table>
    <x-slot name="title">Data Jadwal Mengajar</x-slot>
    
    <x-datatable 
    :route="route('dosen.jadwal_mengajar.data_index')" 
    :table="[
        ['title' => 'No.', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => 'false', 'searchable' => 'false', 'width' => '10'],
        ['title' => 'Semester', 'data' => 'nama_semester', 'name' => 'nama_semester', 'classname' => 'text-center'],
        ['title' => 'Program Studi', 'data' => 'nama_program_studi', 'name' => 'nama_program_studi', 'classname' => 'text-left'],
        ['title' => 'Mata Kuliah', 'data' => 'nama_mata_kuliah', 'name' => 'nama_mata_kuliah', 'classname' => 'text-left'],
        ['title' => 'Kelas', 'data' => 'nama_kelas_kuliah', 'name' => 'nama_kelas_kuliah', 'classname' => 'text-center'],
        ['title' => 'Jadwal', 'data' => 'jadwal', 'name' => 'jadwal', 'classname' => 'text-center'],
        ['title' => 'Presensi', 'data' => 'cetak_presensi', 'name' => 'cetak_presensi', 'classname' => 'text-center']
    ]"
    :filter="[
        ['data' => 'prodi', 'value' => '$(`#prodi`).val()']
    ]"
    />
</x-card-table>

@endsection

@push('js')
    <script>
        $( document ).ready(function() {
            $(document).on('change','#prodi',function(){
                table.ajax.reload();
            });
        });
    </script>
@endpush