@extends('layouts.app')
@section('title', 'Daftar Peserta')

@section('content')
<x-header>
    Daftar Peserta
</x-header>

<x-card-table>
    <x-slot name="title">Daftar Peserta</x-slot>
    
    <x-table>
        <x-slot name="thead">
            <tr>
                <th class="wd-10p">NO</th>
                <th>NIM</th>
                <th>Nama Mahasiswa</th>
                <th>Jenis Kelamin</th>
                <th>Tanggal Lahir</th>
            </tr>
        </x-slot>

        @foreach ($peserta as $item)
            <tr>
                <td class="wd-10p">{{ $loop->iteration }}</td>
                <td>{{ $item->mahasiswa->nim }}</td>
                <td>{{ $item->mahasiswa->nama_mahasiswa }}</td>
                <td>{{ $item->mahasiswa->jenis_kelamin }}</td>
                <td>{{ $item->mahasiswa->tanggal_lahir}}</td>
            </tr>
        @endforeach

    </x-table>
</x-card-table>

@endsection