@extends('layouts.app')
@section('title', 'Histori Pendidikan')

@section('content')

<x-header>
    Histori Pendidikan
</x-header>

<x-card-table>
    <x-slot name="title">Data Histori Pendidikan</x-slot>

    <x-datatable 
    :route="route('mahasiswa.histori_pendidikan.data_index')" 
    :table="[
        ['title' => 'No.', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => 'false', 'searchable' => 'false', 'width' => '10'],                            
        ['title' => 'NIM', 'data' => 'nim', 'name' => 'nim'],
        ['title' => 'Jenis Pendaftaran', 'data' => 'nama_jenis_daftar', 'name' => 'nama_jenis_daftar', 'classname' => 'text-center'],
        ['title' => 'Periode', 'data' => 'nama_periode_masuk', 'name' => 'nama_periode_masuk', 'classname' => 'text-left'],
        ['title' => 'Tanggal Masuk', 'data' => 'tanggal_daftar', 'name' => 'tanggal_daftar'],
        ['title' => 'Perguruan Tinggi', 'data' => 'nama_perguruan_tinggi', 'name' => 'nama_perguruan_tinggi', 'classname' => 'text-left'],
        ['title' => 'Program Studi', 'data' => 'nama_program_studi', 'name' => 'nama_program_studi', 'classname' => 'text-left'],
    ]"
    />

</x-card-table>

@endsection