@extends('layouts.app')
@section('title', 'Transkrip')

@section('content')

<x-header>
    Transkrip
</x-header>

<x-card>
    <div class="row">
        <div class="form-group col-lg-3">
            <label for="periode">Periode</label>
            {!! Form::select('periode', $periode, $semester_id, ['class' => 'form-control', 'id' => 'periode']) !!}
        </div>
    </div>
</x-card>

<x-card-table>
    <x-slot name="title">Data Transkrip</x-slot>

    <x-datatable 
    :route="route('mahasiswa.transkrip.data_index')" 
    :table="[
        ['title' => 'No.', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => 'false', 'searchable' => 'false', 'width' => '10'],                            
        ['title' => 'Kode MK', 'data' => 'kode_mata_kuliah', 'name' => 'kode_mata_kuliah'],
        ['title' => 'Nama MK', 'data' => 'nama_mata_kuliah', 'name' => 'nama_mata_kuliah', 'classname' => 'text-left'],
        ['title' => 'SKS MK', 'data' => 'sks_mata_kuliah', 'name' => 'sks_mata_kuliah'],
        ['title' => 'Nilai Angka', 'data' => 'nilai_angka', 'name' => 'nilai_angka'],
        ['title' => 'Nilai Huruf', 'data' => 'nilai_huruf', 'name' => 'nilai_huruf'],
        ['title' => 'Nilai Indeks', 'data' => 'nilai_indeks', 'name' => 'nilai_indeks'],
        ['title' => 'SKS*N.Indeks', 'data' => 'total_nilai', 'name' => 'total_nilai'],
    ]"
    :filter="[
        ['data' => 'periode', 'value' => '$(`#periode`).val()']
    ]"
    />

</x-card-table>

@endsection


@push('js')
<script>
        $( document ).ready(function() {
            $(document).on('change','#periode',function(){
                table.ajax.reload();
            });
        });
</script>
@endpush