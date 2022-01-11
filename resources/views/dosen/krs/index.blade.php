@extends('layouts.app')
@section('title', 'KRS')

@section('content')

<x-header>
    KRS
</x-header>

<x-card-table>
    <x-slot name="title">KRS</x-slot>
    {{-- <x-slot name="button">
        <a class="btn btn-app btn-sm btn-primary add-form" data-url="{{ route('mahasiswa.krs.store') }}" href="#"><i class="fa fa-plus mr-2"></i>Tambah</a>
    </x-slot> --}}

    <x-datatable 
    :route="route('dosen.krs.data_index')" 
    :table="[
        ['title' => 'No.', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => 'false', 'searchable' => 'false', 'width' => '10'],                            
        {{-- ['title' => 'Program Studi', 'data' => 'prodi', 'name' => 'prodi', 'classname' => 'text-left'], --}}
        ['title' => 'NIM Mahasiswa', 'data' => 'nim_mahasiswa', 'name' => 'nim_mahasiswa', 'classname' => 'text-left'],
        ['title' => 'Nama Mahasiswa', 'data' => 'mahasiswa', 'name' => 'mahasiswa', 'classname' => 'text-left'],
        ['title' => 'Mata Kuliah', 'data' => 'matkul', 'name' => 'matkul','classname' => 'text-left'],
        ['title' => 'Kelas', 'data' => 'kelas', 'name' => 'kelas','classname' => 'text-left'],
        ['title' => 'Ruangan', 'data' => 'ruangan', 'name' => 'ruangan','classname' => 'text-left'],
        ['title' => 'Hari', 'data' => 'hari', 'name' => 'hari'],
        ['title' => 'Jam Mulai', 'data' => 'jam_mulai', 'name' => 'jam_mulai'],
        ['title' => 'Jam Selesai', 'data' => 'jam_selesai', 'name' => 'jam_selesai'],
        ['title' => 'Status', 'data' => 'status', 'name' => 'status'],
        ['title' => 'Aksi', 'data' => 'action', 'orderable' => 'false', 'searchable' => 'false'],
    ]"
    />

</x-card-table>

<x-modal.approve/>

@endsection