@extends('layouts.app')
@section('title', 'Pengisian Nilai')

@section('content')
<x-header>
    Form Pengisian Nilai Peserta Kuliah
</x-header>

<x-card-table>
    <x-slot name="title">Daftar Peserta</x-slot>
    <x-slot name="button">
        <button class="btn btn-app btn-sm btn-primary" onclick="document.getElementById('nilai-form').submit();"><i class="fa fa-save mr-2"></i>Simpan</button>
    </x-slot>

    @if (Session::get('results'))
        <div class="alert alert-danger" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <strong>Error, Periksa Ulang data input...</strong>
            <hr class="message-inner-separator">
            <ul>
                @foreach(Session::get('results') as $key => $item)
                    <li>{{ $item['error_code'].' - '.$item['error_desc'] }}</li>
                @endforeach 
            </ul>
        </div>
    @endif

    <x-table>
        <x-slot name="thead">
            <tr>
                <th class="text-center" style="width: 5%">NO</th>
                <th>NIM</th>
                <th>Nama Mahasiswa</th>
                <th class="text-center" style="width: 15%">Nilai Akhir</th>
            </tr>
        </x-slot>

        <form action="{{ route('dosen.pengisian_nilai.store_nilai') }}" method="post" id="nilai-form">
            @csrf
            <input type="hidden" name="id_kelas_kuliah" value="{{ $kelas_kuliah->id_kelas_kuliah }}">
            <input type="hidden" name="id_prodi" value="{{ $kelas_kuliah->id_prodi }}">
            @foreach ($peserta as $item)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{ $item->nim }}</td>
                <td>{{ $item->nama_mahasiswa }}</td>
                <td  class="text-center"><input class="form-control text-center" type="number" name="{{ $item->id_registrasi_mahasiswa }}" value="{{ $item->nilai_indeks }}" min="0" max="100" required></td>
            </tr>
        @endforeach
        </form>
    </x-table>
</x-card-table>

@endsection