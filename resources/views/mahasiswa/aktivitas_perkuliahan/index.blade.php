@extends('layouts.app')
@section('title', 'Aktivitas Perkuliahan')

@section('content')

<x-header>
    Aktivitas Perkuliahan
</x-header>

<x-card-table>
    <x-slot name="title">Data Aktivitas Perkuliahan</x-slot>

    <x-datatable 
    :route="route('mahasiswa.aktivitas_perkuliahan.data_index')" 
    :table="[
        ['title' => 'No.', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => 'false', 'searchable' => 'false', 'width' => '10'],                            
        ['title' => 'Semester', 'data' => 'nama_semester', 'name' => 'jenis_aktivitas'],
        ['title' => 'Status', 'data' => 'nama_status_mahasiswa', 'name' => 'nama_status_mahasiswa', 'classname' => 'text-center'],
        ['title' => 'IPS', 'data' => 'ips', 'name' => 'ips'],
        ['title' => 'IPK', 'data' => 'ipk', 'name' => 'ipk'],
        ['title' => 'SKS Semester', 'data' => 'sks_semester', 'name' => 'sks_semester'],
        ['title' => 'SKS Total', 'data' => 'sks_total', 'name' => 'sks_total'],
        ['title' => 'Aksi', 'data' => 'action', 'name' => 'action'],
    ]"
    />

</x-card-table>

@endsection