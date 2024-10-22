@extends('layouts.app')
@section('title', 'Histori Nilai')

@section('content')

<x-header>
    Histori Nilai
</x-header>

<x-card>
    <form action="{{ route('mahasiswa.histori_nilai.cetak') }}" method="post" id="form_cetak">
        @csrf
        <div class="row">
            <div class="form-group col-lg-3">
                <label for="semester">Semseter</label>
                {!! Form::select('semester', $semester, null, ['class' => 'form-control', 'id' => 'semester']) !!}
            </div>
        </div>
    </form>
</x-card>

<x-card-table>
    <x-slot name="title">Data Histori Nilai</x-slot>
    <x-slot name="button">
        <button type="button" class="btn btn-app btn-sm btn-primary" onclick="document.getElementById('form_cetak').submit();"><i class="fa fa-print mr-2"></i>Cetak</button>
    </x-slot>

    <x-datatable 
    :route="route('mahasiswa.histori_nilai.data_index')" 
    :table="[
        ['title' => 'No.', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => 'false', 'searchable' => 'false', 'width' => '10'],                            
        ['title' => 'Kode MK', 'data' => 'kode_mata_kuliah', 'name' => 'kode_mata_kuliah'],
        ['title' => 'Nama MK', 'data' => 'nama_mata_kuliah', 'name' => 'nama_mata_kuliah', 'classname' => 'text-left'],
        ['title' => 'SMT', 'data' => 'smt', 'name' => 'smt'],
        ['title' => 'SKS MK', 'data' => 'sks_mata_kuliah', 'name' => 'sks_mata_kuliah'],
        ['title' => 'Nilai Angka', 'data' => 'nilai_angka', 'name' => 'nilai_angka'],
        ['title' => 'Nilai Huruf', 'data' => 'nilai_huruf', 'name' => 'nilai_huruf'],
        ['title' => 'Nilai Indeks', 'data' => 'nilai_indeks', 'name' => 'nilai_indeks'],
        ['title' => 'SKS*N.Indeks', 'data' => 'total_nilai', 'name' => 'total_nilai'],
    ]"
    :filter="[
        ['data' => 'semester', 'value' => '$(`#semester`).val()']
    ]"
    />

</x-card-table>

@endsection


@push('js')
<script>
        $( document ).ready(function() {
            $(document).on('change','#semester',function(){
                table.ajax.reload();
            });
        });
</script>
@endpush