@extends('layouts.app')
@section('title', 'Jurnal Perkuliahan')

@section('content')
<x-header>
    Jurnal Perkuliahan
</x-header>

<x-card-table>
    <x-slot name="title">Jurnal Perkuliahan</x-slot>
    <x-slot name="button">
        <a class="btn btn-app btn-sm btn-primary add-form" href="{{ route('dosen.jurnal_perkuliahan.create', $id_jadwal) }}"><i class="fa fa-plus mr-2"></i>Tambah</a>
    </x-slot>

    <x-datatable 
    :route="route('dosen.jurnal_perkuliahan.jurnal_data_index', $id_jadwal)" 
    :table="[
        ['title' => 'No.', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => 'false', 'searchable' => 'false', 'width' => '10'],
        ['title' => 'Program Studi', 'data' => 'prodi', 'name' => 'prodi', 'classname' => 'text-left'],
        ['title' => 'Tgl Pelaksanaan', 'data' => 'tanggal_pelaksanaan', 'name' => 'tanggal_pelaksanaan', 'classname' => 'text-left'],
        ['title' => 'Topik', 'data' => 'topik', 'name' => 'topik', 'classname' => 'text-left'],
        ['title' => 'Aksi', 'data' => 'action', 'orderable' => 'false', 'searchable' => 'false'],
    ]"
    />
</x-card-table>

@endsection