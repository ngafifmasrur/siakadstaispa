@extends('layouts.app')
@section('title', 'KRS')

@section('content')

<x-header>
    Kartu Rencana Studi (KRS)
</x-header>

<x-card-info>
    <x-slot name="title">Status KRS: {{ $status_krs->status ?? 'Belum Mengajukan' }}</x-slot>
    @if($status_krs == 'Ditolak')
    Alasan Penolakan : {{ $status_krs->alasan_penolakan }}
    @endif
</x-card-info>

<x-card-table>
    <x-slot name="title">Kartu Rencana Studi (KRS)</x-slot>
    <x-slot name="button">
        @if (isset($status_krs))
            <button type="button" class="btn btn-app btn-sm btn-warning" disabled>{{ $status_krs->status }}</button>
        @elseif($status_krs_prodi == false)
            <button type="button" class="btn btn-app btn-sm btn-danger" disabled></i>KRS Prodi Tutup</button>
        @else
            <button type="button" class="btn btn-app btn-sm btn-primary" onclick="document.getElementById('form_pengajuan').submit();"></i>Ajukan</button>
        @endif

        <button type="button" class="btn btn-app btn-sm btn-primary" onclick="document.getElementById('form_cetak').submit();"><i class="fa fa-print mr-2"></i>Cetak</button>
        <a class="btn btn-app btn-sm btn-primary add-form" href="{{ route('mahasiswa.krs.create') }}"><i class="fa fa-plus mr-2"></i>Tambah</a>
    </x-slot>

    <x-krs-table 
    :route="route('mahasiswa.krs.data_index')" 
    :table="[
        ['title' => 'No.', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => 'false', 'searchable' => 'false', 'width' => '10'],                            
        ['title' => 'Nama Mata Kuliah', 'data' => 'nama_mata_kuliah', 'name' => 'nama_mata_kuliah','classname' => 'text-left'],
        ['title' => 'Kelas', 'data' => 'nama_kelas_kuliah', 'name' => 'nama_kelas_kuliah','classname' => 'text-center'],
        ['title' => 'Dosen Pengajar', 'data' => 'nama_dosen', 'name' => 'nama_dosen', 'classname' => 'text-left'],
        ['title' => 'Jadwal', 'data' => 'jadwal', 'name' => 'jadwal','classname' => 'text-left'],
        ['title' => 'SKS', 'data' => 'sks_mata_kuliah', 'name' => 'sks_mata_kuliah'],
        ['title' => 'Aksi', 'data' => 'action', 'orderable' => 'false', 'searchable' => 'false'],
    ]"
    />

</x-card-table>

<form action="{{ route('mahasiswa.krs.cetak') }}" method="post" id="form_cetak">
    @csrf
    </div>
</form>
<form action="{{ route('mahasiswa.krs.ajukan', $id_registrasi_mahasiswa->id_registrasi_mahasiswa) }}" method="post" id="form_pengajuan">
    @csrf
    </div>
</form>

<x-modal.delete/>

@endsection