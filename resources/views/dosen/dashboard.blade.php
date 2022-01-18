@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')

<div class="page-header">
    <ol class="breadcrumb"><!-- breadcrumb -->
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <?php
            $segments = '';
            $total_segments = count(Request::segments());
        ?>
        @foreach(Request::segments() as $key => $segment)
            <?php $segments .= '/'.$segment; ?>
            <li class="breadcrumb-item {{ $key+1 == $total_segments ? 'active' : ''}}" aria-current="page">{{ ucwords(str_replace('_', ' ',$segment)) }}</li>
        @endforeach
    </ol>
</div>

<div class="col-xl-12 col-lg-12 col-md-12">
    <div class="row">
        <div class="col-xl-4 col-lg-6">
            <div class="card overflow-hidden">
                <div class="card-body pb-0">
                    <div class="d-flex">
                        <div>
                            <p class="mb-1 text-uppercase">Total Jadwal Mengajar</p>
                        <h2 class="fs-2 mb-2">{{ $total_jadwal_mengajar }}</h2>
                        <a href="{{ route('dosen.jadwal_mengajar.index') }}" class="btn btn-secondary view-more mb-3">List Jadwal Mengajar</a>
                        </div>
                        <i class="fa fa-calendar fa-5x ml-auto fs-3 op4 text-danger"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-6">
            <div class="card overflow-hidden">
                <div class="card-body pb-0">
                    <div class="d-flex">
                        <div>
                            <p class="mb-1 text-uppercase">Total Mahasiswa Bimbingan</p>
                            <h2 class="fs-2 mb-7">{{ $total_mahasiswa_bimbingan }}</h2>
                        </div>
                        <i class="fa fa-user fa-5x ml-auto fs-3 op4 text-warning"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-xl-12 col-lg-12 col-md-12">
    <div class="card">
        <div class="card-header custom-header pb-0">
            <div>
                <h3 class="card-title">Jadwal Mengajar Hari Ini</h3>
                <h6 class="card-subtitle">{{ Carbon\Carbon::now()->isoFormat('dddd, M Y')}}</h6>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered text-nowrap mb-0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Mata Kuliah</th>
                            <th>Kode MK</th>
                            <th>Ruang</th>
                            <th>Waktu</th>
                            <th>Jumlah Peserta</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($jadwal_mengajar as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->nama_mata_kuliah }}</td>
                                <td>{{ $item->kode_mata_kuliah }}</td>
                                <td>{{ $item->ruangan->nama_ruangan }}</td>
                                <td>{{ $item->jam_mulai.' - '.$item->jam_akhir }}</td>
                                <td><span class="badge badge-success">{{ $item->krs_count }}</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    <p class="text-center">Tidak ada jadwal hari ini</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('css')
    <style>
        .view-more {
            /* border-radius: 10rem; */
            /* padding-left: 0.9em; */
            /* padding-right: 0.9em; */
            padding-top: 0.1em;
            padding-bottom: 0.1em;
        }
    </style>
@endpush