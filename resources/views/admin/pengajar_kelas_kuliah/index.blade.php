@extends('layouts.app')
@section('title', 'Dosen Pengajar Kelas Kuliah')

@section('content')

<x-header>
    Dosen Pengajar Kelas Kuliah
</x-header>

<x-card-info>
    <x-slot name="title">Kelas: {{ $kelas_kuliah->nama_kelas_kuliah }}</x-slot>
    <x-slot name="button">
        <a class="btn btn-app btn-sm btn-danger" href="{{ route('admin.kelas_kuliah.index')}}"><i class="fa fa-arrow-left mr-2"></i>Kembali</a>
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
    <x-slot name="title">Data Dosen Pengajar Kelas Kuliah</x-slot>
    <x-slot name="button">
        <a class="btn btn-app btn-sm btn-primary add-form" data-url="{{ route('admin.pengajar_kelas_kuliah.store', $id_kelas_kuliah)}}" href="#"><i class="fa fa-plus mr-2"></i>Tambah</a>
    </x-slot>

    <x-datatable 
    :route="route('admin.pengajar_kelas_kuliah.data_index', $id_kelas_kuliah)" 
    :table="[
        ['title' => 'No.', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => 'false', 'searchable' => 'false', 'width' => '10'],                            
        ['title' => 'Nama Dosen', 'data' => 'nama_dosen', 'name' => 'nama_dosen', 'classname' => 'text-left'],
        ['title' => 'NIDN', 'data' => 'nidn', 'name' => 'nidn', 'classname' => 'text-left'],
        ['title' => 'Kelas Kuliah', 'data' => 'nama_kelas_kuliah', 'name' => 'nama_kelas_kuliah', 'classname' => 'text-left'],
        ['title' => 'SKS Substansi Total', 'data' => 'sks_substansi_total', 'name' => 'sks_substansi_total', 'classname' => 'text-center'],
        ['title' => 'Jenis Evaluasi', 'data' => 'nama_jenis_evaluasi', 'name' => 'nama_jenis_evaluasi', 'classname' => 'text-left'],
        ['title' => 'Aksi', 'data' => 'action', 'orderable' => 'false', 'searchable' => 'false'],
    ]"
    />

</x-card-table>

<x-modal.delete/>

<x-modal class="modal-form" id="modal-form">
    <x-slot name="title">Dosen Pengajar</x-slot>
    <x-slot name="modalPosition">modal-dialog-centered</x-slot>
    
    @csrf @method('post')
    <div class="row">
        <div class="form-group col-lg-12">
            <label for="id_registrasi_dosen">Dosen</label>
            {!! Form::select('id_registrasi_dosen', $dosen, null, ['class' => 'form-control '.($errors->has('id_registrasi_dosen') ? 'is-invalid' : ''), 'id' => 'id_registrasi_dosen']) !!}
            @error('id_registrasi_dosen')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="row">
        <div class="form-group col-lg-12">
            <label for="id_substansi">Substansi</label>
            {!! Form::select('id_substansi', $substansi_kuliah, null, ['class' => 'form-control '.($errors->has('id_substansi') ? 'is-invalid' : ''), 'id' => 'id_substansi']) !!}
            @error('id_substansi')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="row">
        <div class="form-group col-lg-12">
            <label for="sks_substansi_total">SKS Substansi Total (wajib)</label>
            {!! Form::number('sks_substansi_total', null, ['class' => 'form-control '.($errors->has('sks_substansi_total') ? 'is-invalid' : ''), 'id' => 'sks_substansi_total']) !!}
            @error('sks_substansi_total')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="row">
        <div class="form-group col-lg-12">
            <label for="rencana_minggu_pertemuan">Rencana Minggu Pertemuan (wajib) </label>
            {!! Form::number('rencana_minggu_pertemuan', null, ['class' => 'form-control '.($errors->has('rencana_minggu_pertemuan') ? 'is-invalid' : ''), 'id' => 'rencana_minggu_pertemuan']) !!}
            @error('rencana_minggu_pertemuan')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="row">
        <div class="form-group col-lg-12">
            <label for="realisasi_minggu_pertemuan">Realisasi Minggu Pertemuan</label>
            {!! Form::number('realisasi_minggu_pertemuan', 0, ['class' => 'form-control '.($errors->has('realisasi_minggu_pertemuan') ? 'is-invalid' : ''), 'id' => 'realisasi_minggu_pertemuan', 'min'=>0]) !!}
            @error('realisasi_minggu_pertemuan')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="row">
        <div class="form-group col-lg-12">
            <label for="id_jenis_evaluasi">Jenis Evaluasi (wajib)</label>
            {!! Form::select('id_jenis_evaluasi', $jenis_evaluasi, null, ['class' => 'form-control '.($errors->has('id_jenis_evaluasi') ? 'is-invalid' : ''), 'id' => 'id_jenis_evaluasi']) !!}
            @error('id_jenis_evaluasi')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <x-slot name="footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </x-slot>
</x-modal>

@endsection

@push('js')
    <script>

        $('.add-form').on('click', function () {
            $('.modal-form').modal('show');
            $('.modal-form form')[0].reset();
            $('[name=_method]').val('post');
            $('.modal-form form').attr('action', $(this).data('url'));
        });

        $(document).on('click', '.btn_edit', function () {
            $('.modal-form').modal('show');
            $('.modal-form form')[0].reset();
            $('.modal-form form').attr('action',  $(this).data('route'));
            $('[name=_method]').val('put');
            var nim = $(this).data('nim');
            var id_jenis_daftar = $(this).data('id_jenis_daftar');
            var id_jalur_daftar = $(this).data('id_jalur_daftar');
            var id_periode_masuk = $(this).data('nama');
            var id_perguruan_tinggi = $(this).data('id_perguruan_tinggi');
            var id_prodi = $(this).data('id_prodi');
            var id_perguruan_tinggi_asal = $(this).data('id_perguruan_tinggi_asal');
            var id_prodi_asal = $(this).data('id_prodi_asal');
            var id_pembiayaan = $(this).data('id_pembiayaan');
            var sks_diakui = $(this).data('sks_diakui');

            $('[name=nim]').val(nim);
            $('[name=id_periode]').val(id_periode);
            $('[name=id_jenis_daftar]').val(id_jenis_daftar);
            $('[name=id_periode_masuk]').val(id_periode_masuk);
            $('[name=id_perguruan_tinggi]').val(id_perguruan_tinggi);
            $('[name=id_perguruan_tinggi_asal]').val(id_perguruan_tinggi_asal);
            $('[name=id_prodi_asal]').val(id_prodi_asal);
            $('[name=id_pembiayaan]').val(id_pembiayaan);
            $('[name=sks_diakui]').val(sks_diakui);
        });
    </script>
@endpush