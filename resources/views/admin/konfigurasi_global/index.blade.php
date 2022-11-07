@extends('layouts.app')
@section('title', 'Konfigurasi Global')

@section('content')
<x-header>
    Konfigurasi Global
</x-header>

<x-card-table>
    <x-slot name="title">Konfigurasi Global</x-slot>
    <x-slot name="button">
        <a class="btn btn-app btn-sm btn-primary add-form" href="{{ route('admin.konfigurasi_global.edit') }}"><i class="fa fa-gear mr-2"></i>Ubah Konfigurasi</a>
    </x-slot>

    <div class="row">
        <div class="col-lg-6 col-md-12">
            <table class="table card-table table-vcenter text-nowrap  align-items-center">
                <tr>
                    <td class="font-weight-bold">Semester Berlaku (Aktif)</td>
                    <td>{{ $konfigurasi_global->semester_aktif->nama_semester }}</td>
                </tr>
                <tr>
                    <td class="font-weight-bold">Semester Nilai</td>
                    <td>{{ $konfigurasi_global->semester_nilai->nama_semester }}</td>
                </tr>
                <tr>
                    <td class="font-weight-bold">Perhitungan Mata Kuliah Mengulang</td>
                    <td>{{ $konfigurasi_global->perhitungan_matkul }}</td>
                </tr>
                <tr>
                    <td class="font-weight-bold">Wakil Ketua Bidang Akademik</td>
                    <td>{{ $konfigurasi_global->wakil_ketua_bidang_akademik }}</td>
                </tr>
            </table>
        </div>
        <div class="col-lg-6 col-md-12">
            <table class="table card-table table-vcenter text-nowrap  align-items-center">
                <tr>
                    <td class="font-weight-bold">Semester KRS</td>
                    <td>{{ $konfigurasi_global->semester_krs->nama_semester }}</td>
                </tr>
                <tr>
                    <td class="font-weight-bold">Semester Pengisian Tracer Study</td>
                    <td>{{ $konfigurasi_global->semester_tracer->nama_semester }}</td>
                </tr>
                <tr>
                    <td class="font-weight-bold">Batas SKS KRS</td>
                    <td>{{ $konfigurasi_global->batas_sks_krs }}</td>
                </tr>
            </table>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <table class="table card-table table-vcenter text-nowrap  align-items-center">
                <thead class="bg-primary text-white">
                    <tr>
                        <th class="text-center">No.</th>
                        <th>Nama Prodi</th>
                        <th class="text-center">Buka KRS</th>
                        <th class="text-center">Buka Penilaian</th>
                        <th class="text-center">Buka KHS</th>
                        <th class="text-center">Buka Transkip</th>
                        <th class="text-center">Buka Kartu Ujian</th>
                    </tr>
                </thead>
                @forelse ($konfigurasi_global_prodi as $key => $item)
                <tr>
                    <td class="text-center">{{ $key+1 }}</td>
                    <td>{{ $item->nama_prodi }}</td>
                    <td class="text-center">{!! $item->buka_krs  ? '<i class="fa fa-check" aria-hidden="true"></i>' : '<i class="fa fa-times" aria-hidden="true"></i>' !!}</td>
                    <td class="text-center">{!! $item->buka_penilaian   ? '<i class="fa fa-check" aria-hidden="true"></i>' : '<i class="fa fa-times" aria-hidden="true"></i>' !!}</td>
                    <td class="text-center">{!! $item->buka_khs   ? '<i class="fa fa-check" aria-hidden="true"></i>' : '<i class="fa fa-times" aria-hidden="true"></i>' !!}</td>
                    <td class="text-center">{!! $item->buka_transkrip   ? '<i class="fa fa-check" aria-hidden="true"></i>' : '<i class="fa fa-times" aria-hidden="true"></i>' !!}</td>
                    <td class="text-center">{!! $item->buka_kartu_ujian   ? '<i class="fa fa-check" aria-hidden="true"></i>' : '<i class="fa fa-times" aria-hidden="true"></i>' !!}</td>
                </tr>
                @empty
                    Tidak ada program studi
                @endforelse
            </table>
        </div>
    </div>

</x-card-table>

@endsection