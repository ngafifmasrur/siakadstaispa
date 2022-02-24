@extends('layouts.app')
@section('title', 'Absensi Mahasiswa')

@section('content')

<div class="page-header">
    <ol class="breadcrumb"><!-- breadcrumb -->
        <li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item" aria-current="page">Mahasiswa</li>
        <li class="breadcrumb-item active" aria-current="page">Absen</li>
    </ol>
</div>
<!-- Main page content-->

<x-card-info>
    <x-slot name="title">Absensi Mahasiswa</x-slot>
    <table cellpadding="4" cellspacing="2">
        <tr>
            <td class="font-weight-bold">Kelas Kuliah</td>
            <td>:</td>
            <td>{{ $jurnal_kuliah->kelas->nama_kelas_kuliah }}</td>
        </tr>
        <tr>
            <td class="font-weight-bold">Mata Kuliah</td>
            <td>:</td>
            <td>{{ $jurnal_kuliah->kelas->nama_mata_kuliah }}</td>
        </tr>
        <tr>
            <td class="font-weight-bold">Tanggal Pelaksanaan</td>
            <td>:</td>
            <td>{{ $jurnal_kuliah->tanggal_pelaksanaan }}</td>
        </tr>
        <tr>
            <td class="font-weight-bold">Keterangan Absen</td>
            <td>:</td>
            <td class="font-weight-bold text-primary">{{ $absensi_mahasiswa->status }}</td>
        </tr>
    </table>
</x-card-info>

<x-card-table>
    <x-slot name="title">Absen</x-slot>
    <form action="{{ route('mahasiswa.absen.store')}}" method="post" id="form_setting">
        @csrf
            <div class="tabs-menu1 ">
                <ul class="nav panel-tabs" id="cardTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="identitas-tab" href="#identitas" data-toggle="tab" role="tab" aria-controls="overview" aria-selected="true">Absen</a>
                    </li>
                </ul>
            </div>
            {!! Form::hidden('id_jurnal_kuliah', $jurnal_kuliah->id, ['class' => 'form-control', 'id' => 'id_jurnal_kuliah']) !!}
            <div class="card-body">
                <div class="tab-content" id="cardTabContent">
                    <div class="tab-pane fade show active" id="identitas" role="tabpanel" aria-labelledby="overview-tab">
                        <div class="form-group">
                            <label for="status">Status</label>
                            {!! Form::select('status', $status, $absensi_mahasiswa->status ?? null, ['class' => 'form-control', 'id' => 'status']) !!}
                        </div>
                    </div>
                </div>
            </div>

            <button class="float-right btn btn-primary" type="submit">Simpan</button>
    </form>
</x-card-table>
@endsection