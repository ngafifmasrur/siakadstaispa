@extends('layouts.app')
@section('title', 'Transkrip')

@section('content')

<x-header>
    Transkrip
</x-header>

<x-card-table>
    <x-slot name="title">Data Transkrip</x-slot>
    <x-slot name="button">
        <button type="button" class="btn btn-app btn-sm btn-primary" onclick="document.getElementById('form_cetak').submit();"><i class="fa fa-print mr-2"></i>Cetak</button>
    </x-slot>

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
    />

</x-card-table>

<form action="{{ route('mahasiswa.transkrip.cetak') }}" method="post" id="form_cetak">
    @csrf
</form>

@endsection