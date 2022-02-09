@extends('layouts.app')
@section('title', 'Semester')

@section('content')

<x-header>
    Semester
</x-header>
<!-- Main page content-->
<x-card-table>
    <x-slot name="title">Data Semester</x-slot>
    {{-- <x-slot name="button">
        <a class="btn btn-app btn-sm btn-primary add-form" data-url="{{ route('admin.semester.store') }}" href="#"><i class="fa fa-plus mr-2"></i>Tambah</a>
    </x-slot> --}}

    <x-datatable 
    :route="route('admin.semester.data_index')" 
    :table="[
        ['title' => 'No.', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => 'false', 'searchable' => 'false', 'width' => '10'],  
        ['title' => 'Tahun Ajaran', 'data' => 'id_tahun_ajaran', 'name' => 'id_tahun_ajaran'],            
        ['title' => 'Semester', 'data' => 'semester', 'name' => 'semester'],              
        ['title' => 'Nama Semester', 'data' => 'nama_semester', 'name' => 'nama_semester', 'classname' => 'text-left'],
        ['title' => 'Status', 'data' => 'aktif', 'name' => 'aktif'],
        ['title' => 'Tanggal Mulai', 'data' => 'tanggal_mulai', 'name' => 'tanggal_mulai'],
        ['title' => 'Tanggal Selesai', 'data' => 'tanggal_selesai', 'name' => 'tanggal_selesai']
    ]"
    />

</x-card-table>

@endsection