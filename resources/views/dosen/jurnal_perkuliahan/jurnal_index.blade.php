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
        ['title' => 'Tgl Pelaksanaan', 'data' => 'tanggal_pelaksanaan', 'name' => 'tanggal_pelaksanaan', 'classname' => 'text-center'],
        ['title' => 'Jadwal', 'data' => 'jadwal', 'name' => 'jadwal', 'classname' => 'text-center'],
        ['title' => 'Topik', 'data' => 'topik', 'name' => 'topik', 'classname' => 'text-left'],
        ['title' => 'Absen MHS', 'data' => 'absen_mahasiswa', 'name' => 'absen_mahasiswa'],
        ['title' => 'Aksi', 'data' => 'action', 'orderable' => 'false', 'searchable' => 'false'],
    ]"
    />
</x-card-table>

<x-modal.delete/>

<div class="modal fade" id="ModalShare" tabindex="-1" role="dialog" aria-labelledby="share_title"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="share_title">Share</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <ul id="list_jurnal">
                    <li>Kode Mata Kuliah : <strong id="kode_matkul"></strong></li>
                    <li>Nama Mata Kuliah : <strong id="matkul"></strong></li>
                    <li>Kelas : <strong id="kelas"></strong></li>
                    <li>Tanggal : <strong id="tanggal"></strong></li>
                    <li>Link absensi : <strong id="link_absensi"></strong></li>
                    <li>Link Zoom : <strong id="link_zoom"></strong></li>
                </ul>
                <textarea id="auto" class="form-control"></textarea>

            </div>
            <div class="modal-footer">
                <button class="btn btn-light" type="button" data-dismiss="modal">Close
                </button>
                <button class="btn btn-success" type="button" id="btn_copy" onclick="copyJurnal()">
                    Copy
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    $(document).ready(function(){
        $(document).on('click','.btn_share',function(){
            let kode_matkul = $(this).data('kode_matkul');
            let nama_matkul = $(this).data('nama_matkul');
            let nama_kelas = $(this).data('nama_kelas');
            let tanggal_pelaksanaan = $(this).data('tanggal_pelaksanaan');
            let link_absensi = $(this).data('link_absensi');
            let link_zoom = $(this).data('link_zoom');

            $('#matkul').html(nama_matkul);
            $('#kelas').html(nama_kelas);
            $('#kode_matkul').html(kode_matkul);
            $('#tanggal').html(tanggal_pelaksanaan);
            $('#link_absensi').html(link_absensi);
            $('#link_zoom').html(link_zoom);
            document.getElementById("auto").value = "";
            $('#ModalShare').modal('show');
        });
        
    });

    function copyJurnal() {
        var thelist = $('#list_jurnal').html();
        thelist = thelist.replace(/\s+<li>/g, '');
        thelist = thelist.replace(/<\/?li>/g, '\r');
        thelist = thelist.replace(/<\/?strong>/g, '');
        thelist = thelist.replace(/\s+<strong id="kode_matkul">/g, '');
        thelist = thelist.replace(/\s+<strong id="kelas">/g, '');
        thelist = thelist.replace(/\s+<strong id="matkul">/g, '');
        thelist = thelist.replace(/\s+<strong id="tanggal">/g, '');
        thelist = thelist.replace(/\s+<strong id="link_absensi">/g, '');
        thelist = thelist.replace(/\s+<strong id="link_zoom">/g, '');


        $('#auto').val(thelist);

        /* Copy the text inside the text field */
        document.getElementById("auto").select();
        document.execCommand("copy");
        alert("Berhasil dicopy");
    }
</script>
@endpush