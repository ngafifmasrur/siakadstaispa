@extends('layouts.app')
@section('title', 'Tahun Ajaran')

@section('content')

<x-header>
    Tahun Ajaran
</x-header>
<!-- Main page content-->
<x-card-table>
    <x-slot name="title">Data Tahun Ajaran</x-slot>
    {{-- <x-slot name="button">
        <a class="btn btn-app btn-sm btn-primary add-form" data-url="{{ route('admin.tahun_ajaran.store') }}" href="#"><i class="fa fa-plus mr-2"></i>Tambah</a>
    </x-slot> --}}

    <x-datatable 
    :route="route('admin.tahun_ajaran.data_index')" 
    :table="[
        ['title' => 'No.', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => 'false', 'searchable' => 'false', 'width' => '10'],  
        ['title' => 'Tahun Ajaran', 'data' => 'id_tahun_ajaran', 'name' => 'id_tahun_ajaran'],                          
        ['title' => 'Nama Tahun Ajaran', 'data' => 'nama_tahun_ajaran', 'name' => 'nama_tahun_ajaran', 'classname' => 'text-left'],
        ['title' => 'Status', 'data' => 'aktif', 'name' => 'aktif'],
        ['title' => 'Tanggal Mulai', 'data' => 'tanggal_mulai', 'name' => 'tanggal_mulai'],
        ['title' => 'Tanggal Selesai', 'data' => 'tanggal_selesai', 'name' => 'tanggal_selesai']
    ]"
    />

</x-card-table>


@endsection
