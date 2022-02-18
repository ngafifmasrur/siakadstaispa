@extends('layouts.app')
@section('title', 'Dosen Wali')

@section('content')
<x-header>
    Dosen Wali
</x-header>

<x-card-table>
    <x-slot name="title">Data Dosen Wali</x-slot>
    <x-slot name="button">
        <a class="btn btn-app btn-sm btn-primary add-form" href="{{ route('admin.dosen_wali.create') }}"><i class="fa fa-plus mr-2"></i>Tambah</a>
    </x-slot>
    
    <x-datatable 
    :route="route('admin.dosen_wali.data_index')" 
    :table="[
        ['title' => 'No.', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => 'false', 'searchable' => 'false', 'width' => '10'],
        ['title' => 'NIDN', 'data' => 'nidn', 'name' => 'nidn', 'classname' => 'text-left'],
        ['title' => 'Nama Dosen', 'data' => 'nama_dosen', 'name' => 'nama_dosen', 'classname' => 'text-left'],
        ['title' => 'Mahasiswa', 'data' => 'mahasiswa', 'name' => 'mahasiswa', 'width' => '40'],
        ['title' => 'Aksi', 'data' => 'action', 'orderable' => 'false', 'searchable' => 'false'],
    ]"
    />
</x-card-table>

<x-modal.delete/>

@endsection