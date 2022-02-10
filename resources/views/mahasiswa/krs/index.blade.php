@extends('layouts.app')
@section('title', 'KRS')

@section('content')

<x-header>
    Kartu Rencana Studi (KRS)
</x-header>

<x-card-table>
    <x-slot name="title">Kartu Rencana Studi (KRS)</x-slot>
    <x-slot name="button">
        <a class="btn btn-app btn-sm btn-primary add-form" href="{{ route('mahasiswa.krs.create') }}"><i class="fa fa-plus mr-2"></i>Tambah</a>
    </x-slot>

    <x-krs-table 
    :route="route('mahasiswa.krs.data_index')" 
    :table="[
        ['title' => 'No.', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => 'false', 'searchable' => 'false', 'width' => '10'],                            
        ['title' => 'Nama Mata Kuliah', 'data' => 'nama_mata_kuliah', 'name' => 'nama_mata_kuliah','classname' => 'text-left'],
        ['title' => 'Kelas', 'data' => 'nama_kelas_kuliah', 'name' => 'nama_kelas_kuliah','classname' => 'text-left'],
        ['title' => 'Dosen Pengajar', 'data' => 'nama_dosen', 'name' => 'nama_dosen', 'classname' => 'text-left'],
        ['title' => 'Ruangan', 'data' => 'ruangan', 'name' => 'ruangan','classname' => 'text-left'],
        ['title' => 'SKS', 'data' => 'sks_mata_kuliah', 'name' => 'sks_mata_kuliah'],
        ['title' => 'Aksi', 'data' => 'action', 'orderable' => 'false', 'searchable' => 'false'],
    ]"
    />

</x-card-table>

<x-modal.delete/>

@endsection