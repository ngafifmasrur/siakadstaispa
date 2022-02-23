@extends('layouts.app')
@section('title', 'KRS')

@section('content')

<x-header>
    Kartu Rencana Studi (KRS)
</x-header>

<x-card-info>
    <x-slot name="title">Status KRS: <strong>{{ isset($status_krs) ? $status_krs->status : 'Belum Mengajukan' }}</strong></x-slot>
    @if (isset($status_krs))
        @if($status_krs->status == 'Ditolak')
        <strong>Alasan Penolakan</strong> : {{ $status_krs->alasan_penolakan }}
        @endif
    @endif
</x-card-info>

<x-card-table>
    <x-slot name="title">Kartu Rencana Studi (KRS)</x-slot>
    <x-slot name="button">
        @if((isset($status_krs) && ($status_krs->status == 'Diajukan' || $status_krs->status == 'Diverifikasi')))
            <button type="button" class="btn btn-app btn-sm btn-info" disabled><i class="fa fa-info mr-2"></i>{{ $status_krs->status }}</button>
        @elseif($status_krs_prodi == false)
            <button type="button" class="btn btn-app btn-sm btn-danger" disabled></i>KRS Prodi Tutup</button>
        @elseif($jumlah_kelas == 0)
            <button type="button" class="btn btn-app btn-sm btn-danger" disabled></i>Pilih Kelas Untuk Mengajukan</button>
        @elseif(isset($status_krs) &&  $status_krs->status == 'Ditolak')
            <button type="button" class="btn btn-app btn-sm btn-primary" onclick="document.getElementById('form_pengajuan').submit();"></i>Ajukan Ulang</button>
        @else
            <button type="button" class="btn btn-app btn-sm btn-primary" onclick="document.getElementById('form_pengajuan').submit();"></i>Ajukan</button>
        @endif


         <button type="button" class="btn btn-app btn-sm btn-primary" onclick="document.getElementById('form_cetak').submit();"><i class="fa fa-print mr-2"></i>Cetak</button>
        @if((isset($status_krs) && ($status_krs->status == 'Diajukan' || $status_krs->status == 'Diverifikasi')) || $status_krs_prodi == false)
            <button class="btn btn-app btn-sm btn-primary add-form" disabled><i class="fa fa-plus mr-2"></i>Tambah</button>
        @else
            <a class="btn btn-app btn-sm btn-primary add-form" href="{{ route('mahasiswa.krs.create') }}"><i class="fa fa-plus mr-2"></i>Tambah</a>
        @endif
    </x-slot>

    <x-krs-table 
    :route="route('mahasiswa.krs.data_index')" 
    :table="[
        ['title' => 'No.', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => 'false', 'searchable' => 'false', 'width' => '10'],
        ['title' => 'Kode MK', 'data' => 'kode_mata_kuliah', 'name' => 'kode_mata_kuliah'],                           
        ['title' => 'Mata Kuliah', 'data' => 'nama_mata_kuliah', 'name' => 'nama_mata_kuliah','classname' => 'text-left'],
        ['title' => 'SMT', 'data' => 'smt', 'name' => 'smt'],
        ['title' => 'Kelas', 'data' => 'nama_kelas_kuliah', 'name' => 'nama_kelas_kuliah','classname' => 'text-center'],
        ['title' => 'Dosen Pengajar', 'data' => 'nama_dosen', 'name' => 'nama_dosen', 'classname' => 'text-left'],
        ['title' => 'Jadwal', 'data' => 'jadwal', 'name' => 'jadwal'],
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