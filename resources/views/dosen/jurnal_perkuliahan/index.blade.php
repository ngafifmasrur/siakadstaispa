@extends('layouts.app')
@section('title', 'Jurnal Perkuliahan')

@section('content')
<x-header>
    Jurnal Perkuliahan
</x-header>

<x-card-table>
    <x-slot name="title">Jurnal Perkuliahan</x-slot>
    
    <x-datatable 
    :route="route('dosen.jurnal_perkuliahan.data_index')" 
    :table="[
        ['title' => 'No.', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => 'false', 'searchable' => 'false', 'width' => '10'],
        ['title' => 'Nama Mata Kuliah', 'data' => 'nama_matkul', 'name' => 'nama_matkul', 'classname' => 'text-left'],
        ['title' => 'Kode MK', 'data' => 'kode_matkul', 'name' => 'kode_matkul'],
        ['title' => 'Kelas', 'data' => 'kelas', 'name' => 'kelas', 'classname' => 'text-left'],
        ['title' => 'Ruang', 'data' => 'ruangan', 'name' => 'ruangan'],
        ['title' => 'Waktu', 'data' => 'jadwal', 'name' => 'jadwal', 'classname' => 'text-left'],
        ['title' => 'JmL Peserta', 'data' => 'jumlah_peserta', 'name' => 'jumlah_peserta'],
        ['title' => 'Ket.', 'data' => 'action', 'orderable' => 'false', 'searchable' => 'false'],
    ]"
    />
</x-card-table>

@endsection