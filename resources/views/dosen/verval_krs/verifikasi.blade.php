@extends('layouts.app')
@section('title', 'Verikasi KRS Mahasiswa')

@section('content')

<x-header>
    Verikasi KRS Mahasiswa
</x-header>

<x-card-info>
    <x-slot name="title">Form Verifikasi</x-slot>
    <x-slot name="button">
        <a class="btn btn-app btn-sm btn-danger" href="{{ route('dosen.verval_krs.index')}}"><i class="fa fa-arrow-left mr-2"></i>Kembali</a>
        <button type="button" class="btn btn-app btn-sm btn-primary" onclick="document.getElementById('form_verifikasi').submit();"><i class="fa fa-check mr-2"></i>Verifikasi</button>
    </x-slot>
    <form action="{{ route('dosen.verval_krs.update_status', $krs_mahasiswa->id)}}" method="post" id="form_verifikasi">
        @csrf
        <div class="form-group row">
            <label for="status" class="col-sm-2 col-form-label">Status</label>
            <div class="col-sm-10">
                {!! Form::select('status', [NULL => 'Pilih Status','Diverifikasi' => 'Setujui', 'Ditolak' => 'Tolak'], null, ['class' => 'form-control '.($errors->has('status') ? 'is-invalid' : ''), 'id' => 'status']) !!}
                @error('status')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
        <div id="catatan" class="form-group row"></div>
    </form>
</x-card-info>

<x-card-info>
    <x-slot name="title">Mahasiswa</x-slot>

    <table cellpadding="4" cellspacing="2">
        <tr>
            <td class="font-weight-bold">NIM</td>
            <td>:</td>
            <td>{{ $mahasiswa->nim }}</td>
        </tr>
        <tr>
            <td class="font-weight-bold">Nama Mahasiswa</td>
            <td>:</td>
            <td>{{ $mahasiswa->nama_mahasiswa }}</td>
        </tr>
        <tr>
            <td class="font-weight-bold">Program Studi</td>
            <td>:</td>
            <td>{{ $mahasiswa->nama_program_studi }}</td>
        </tr>
    </table>
</x-card-info>

<x-card-table>
    <x-slot name="title">Kartu Rencana Studi (KRS) Mahasiswa</x-slot>

    <x-krs-table 
    :route="route('dosen.verval_krs.verifikasi_data_index', $id_registrasi_mahasiswa)" 
    :table="[
        ['title' => 'No.', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => 'false', 'searchable' => 'false', 'width' => '10'],                            
        ['title' => 'Nama Mata Kuliah', 'data' => 'nama_mata_kuliah', 'name' => 'nama_mata_kuliah','classname' => 'text-left'],
        ['title' => 'SMT', 'data' => 'smt', 'name' => 'smt'],
        ['title' => 'Kelas', 'data' => 'nama_kelas_kuliah', 'name' => 'nama_kelas_kuliah','classname' => 'text-center'],
        ['title' => 'Dosen Pengajar', 'data' => 'nama_dosen', 'name' => 'nama_dosen', 'classname' => 'text-left'],
        ['title' => 'Jadwal', 'data' => 'jadwal', 'name' => 'jadwal','classname' => 'text-left'],
        ['title' => 'SKS', 'data' => 'sks_mata_kuliah', 'name' => 'sks_mata_kuliah'],
        ['title' => 'Aksi', 'data' => 'action', 'orderable' => 'false', 'searchable' => 'false'],
    ]"
    />

</x-card-table>
@endsection

@push('css')
    <style>
        .form-group {
            display: flex!important;
        }
    </style>
@endpush


@push('js')
<script>

    $( document ).ready(function() {
            $(document).on('change','#status',function(){
                status = document.getElementById("status").value;
                if(status == 'Ditolak') {
                    $('#catatan').html('<label for="status" class="col-sm-2 col-form-label">Alasan Penolakan</label><div class="col-sm-10"><textarea class="form-control" name="alasan_penolakan" placeholder="Alasan Penolakan..." cols="10" rows="5"></textarea></div>');
                } else {
                    $('#catatan').html('');
                }           
             });
    });
</script>
@endpush