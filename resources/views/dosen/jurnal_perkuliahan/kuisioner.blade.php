@extends('layouts.app')
@section('title', 'Kuisioner')

@section('content')
<x-header>
    Hasil Kuisioner
</x-header>
<x-card-table>
    <x-slot name="title">Data Hasil Kuisioner</x-slot>
    
    <x-datatable 
    :route="route('dosen.kuisioner.data',$id_kelas_kuliah)" 
    :table="[
        ['title' => 'No.', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => 'false', 'searchable' => 'false', 'width' => '10'],
        ['title' => 'Mahasiswa', 'data' => 'nama_mahasiswa', 'name' => 'nama_mahasiswa', 'classname' => 'text-center'],
        ['title' => 'Skor', 'data' => 'skor', 'name' => 'skor'],
        ['title' => 'Detail', 'data' => 'action', 'name' => 'action', 'classname' => 'text-center']
    ]"
    />
</x-card-table>

@endsection
