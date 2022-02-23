@extends('layouts.app')
@section('title', 'Jurnal Perkuliahan')

@section('content')
<x-header>
    Jurnal Perkuliahan
</x-header>

<x-card-info>
    <x-slot name="title">Kelas: {{ $kelas_kuliah->nama_kelas_kuliah }}</x-slot>
    <x-slot name="button">
        <a class="btn btn-app btn-sm btn-danger" href="{{ route('dosen.jurnal_perkuliahan.index')}}"><i class="fa fa-arrow-left mr-2"></i>Kembali</a>
    </x-slot>


    <table cellpadding="4" cellspacing="2">
        <tr>
            <td class="font-weight-bold">Kode Mata Kuliah</td>
            <td>:</td>
            <td>{{ $kelas_kuliah->kode_mata_kuliah }}</td>
        </tr>
        <tr>
            <td class="font-weight-bold">Nama Mata Kuliah</td>
            <td>:</td>
            <td>{{ $kelas_kuliah->nama_mata_kuliah }}</td>
        </tr>
        <tr>
            <td class="font-weight-bold">Program Studi</td>
            <td>:</td>
            <td>{{ $kelas_kuliah->nama_program_studi }}</td>
        </tr>
        <tr>
            <td class="font-weight-bold">Semester</td>
            <td>:</td>
            <td>{{ $kelas_kuliah->nama_semester }}</td>
        </tr>
    </table>
</x-card-info>

<x-card-table>
    <x-slot name="title">Jurnal Perkuliahan</x-slot>
    <x-slot name="button">
        <a class="btn btn-app btn-sm btn-primary add-form" href="{{ route('dosen.jurnal_perkuliahan.create', $jadwal->id_kelas_kuliah) }}"><i class="fa fa-plus mr-2"></i>Tambah</a>
    </x-slot>

    <x-datatable 
    :route="route('dosen.jurnal_perkuliahan.jurnal_data_index', $jadwal->id_kelas_kuliah)" 
    :table="[
        ['title' => 'No.', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => 'false', 'searchable' => 'false', 'width' => '10'],
        ['title' => 'Program Studi', 'data' => 'nama_program_studi', 'name' => 'nama_program_studi', 'classname' => 'text-left'],
        ['title' => 'Tgl Pelaksanaan', 'data' => 'tanggal_pelaksanaan', 'name' => 'tanggal_pelaksanaan', 'classname' => 'text-left'],
        ['title' => 'Topik', 'data' => 'topik', 'name' => 'topik', 'classname' => 'text-left'],
        ['title' => 'Absen MHS', 'data' => 'absen_mahasiswa', 'name' => 'absen_mahasiswa'],
        ['title' => 'Aksi', 'data' => 'action', 'orderable' => 'false', 'searchable' => 'false'],
    ]"
    />
</x-card-table>

<x-modal.delete/>

@endsection