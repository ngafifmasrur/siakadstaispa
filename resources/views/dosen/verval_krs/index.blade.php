@extends('layouts.app')
@section('title', 'Perwalian')

@section('content')

<x-header>
    Perwalian
</x-header>

<x-card-table>
    <x-slot name="title">Perwalian</x-slot>
    {{-- <x-slot name="button">
        <a class="btn btn-app btn-sm btn-primary add-form" data-url="{{ route('mahasiswa.krs.store') }}" href="#"><i class="fa fa-plus mr-2"></i>Tambah</a>
    </x-slot> --}}

    <x-datatable 
    :route="route('dosen.verval_krs.data_index')" 
    :table="[
        ['title' => 'No.', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => 'false', 'searchable' => 'false', 'width' => '10'],                            
        ['title' => 'NIM Mahasiswa', 'data' => 'nim_mahasiswa', 'name' => 'nim_mahasiswa', 'classname' => 'text-center'],
        ['title' => 'Nama Mahasiswa', 'data' => 'mahasiswa', 'name' => 'mahasiswa', 'classname' => 'text-left'],
        ['title' => 'Program Studi', 'data' => 'nama_program_studi', 'name' => 'nama_program_studi', 'classname' => 'text-left'],
        ['title' => 'Status', 'data' => 'status', 'name' => 'status'],
        ['title' => 'Aksi', 'data' => 'action', 'name' => 'action'],
    ]"
    />

</x-card-table>

@endsection