@extends('layouts.app')
@section('title', 'Ubah Konfigurasi Global')

@section('content')
<x-header>
    Ubah Konfigurasi Global
</x-header>

<x-card-table>
    <x-slot name="title">Ubah Konfigurasi Global</x-slot>
    <x-slot name="button">
        <button type="button" class="btn btn-app btn-sm btn-primary add-form" onclick="document.getElementById('form_konfigurasi').submit();"><i class="fa fa-save mr-2"></i>Simpan</button>
    </x-slot>

    <form action="{{ route('admin.konfigurasi_global.update') }}" method="post" id="form_konfigurasi">
        @csrf @method('post')
        <div class="row">
            <div class="col-lg-6 col-md-12">
                <table class="table card-table table-vcenter text-nowrap  align-items-center">
                    <tr>
                        <td class="font-weight-bold">Semester Berlaku (Aktif)</td>
                        <td>{!! Form::select('id_semester_aktif', $semester, $konfigurasi_global->id_semester_aktif, ['class' => 'form-control', 'id' => 'id_semester_aktif']) !!}</td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">Semester Nilai</td>
                        <td>{!! Form::select('id_semester_nilai', $semester, $konfigurasi_global->id_semester_nilai, ['class' => 'form-control', 'id' => 'id_semester_nilai']) !!}</td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">Perhitungan Mata Kuliah Mengulang</td>
                        <td>{!! Form::select('perhitungan_matkul', ['Nilai Tertinggi' => 'Nilai Tertinggi'], $konfigurasi_global->perhitungan_matkul, ['class' => 'form-control', 'id' => 'perhitungan_matkul']) !!}</td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">Wakil Ketua Bidang Akademik</td>
                        <td>{!! Form::text('wakil_ketua_bidang_akademik', $konfigurasi_global->wakil_ketua_bidang_akademik, ['class' => 'form-control', 'id' => 'wakil_ketua_bidang_akademik']) !!}</td>
                    </tr>
                </table>
            </div>
            <div class="col-lg-6 col-md-12">
                <table class="table card-table table-vcenter text-nowrap  align-items-center">
                    <tr>
                        <td class="font-weight-bold">Semester KRS</td>
                        <td>{!! Form::select('id_semester_krs', $semester, $konfigurasi_global->id_semester_krs, ['class' => 'form-control', 'id' => 'id_semester_krs']) !!}</td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">Semester Pengisian Tracer Study</td>
                        <td>{!! Form::select('id_semester_tracer_study', $semester, $konfigurasi_global->id_semester_tracer_study, ['class' => 'form-control', 'id' => 'id_semester_tracer_study']) !!}</td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">Batas SKS KRS</td>
                        <td>{!! Form::number('batas_sks_krs', $konfigurasi_global->batas_sks_krs, ['class' => 'form-control', 'id' => 'batas_sks_krs']) !!}</td>
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
                        <td class="text-center">{!! $item->buka_krs  ? '<input type="checkbox" value="1" name="buka_krs_'.$key.'" class="form-checkbox" checked>' : '<input type="checkbox" value="1" name="buka_krs_'.$key.'" class="form-checkbox">' !!}</td>
                        <td class="text-center">{!! $item->buka_penilaian  ? '<input type="checkbox" value="1" name="buka_penilaian_'.$key.'" class="form-checkbox" checked>' : '<input type="checkbox" value="1" name="buka_penilaian_'.$key.'" class="form-checkbox">' !!}</td>
                        <td class="text-center">{!! $item->buka_khs  ? '<input type="checkbox" value="1" name="buka_khs_'.$key.'" class="form-checkbox" checked>' : '<input type="checkbox" value="1" name="buka_khs_'.$key.'" class="form-checkbox">' !!}</td>
                        <td class="text-center">{!! $item->buka_transkrip  ? '<input type="checkbox" value="1" name="buka_transkrip_'.$key.'" class="form-checkbox" checked>' : '<input type="checkbox" value="1" name="buka_transkrip_'.$key.'" class="form-checkbox">' !!}</td>
                        <td class="text-center">{!! $item->buka_kartu_ujian  ? '<input type="checkbox" value="1" name="buka_kartu_ujian_'.$key.'" class="form-checkbox" checked>' : '<input type="checkbox" value="1" name="buka_kartu_ujian_'.$key.'" class="form-checkbox">' !!}</td>
                    </tr>
                    @empty
                        Tidak ada program studi
                    @endforelse
                </table>
            </div>
        </div>
    </form>

</x-card-table>

@endsection