@extends('layouts.app')
@section('title', 'Peserta Kelas Kuliah')

@section('content')

<x-header>
    Peserta Kelas Kuliah
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
    <x-slot name="title">Data Peserta Kelas Kuliah</x-slot>
    <x-slot name="button">
        <a class="btn btn-app btn-sm btn-primary add-form" data-url="{{ route('admin.peserta_kelas_kuliah.store', $id_kelas_kuliah) }}" href="#"><i class="fa fa-plus mr-2"></i>Tambah</a>
    </x-slot>

    <x-datatable 
    :route="route('admin.peserta_kelas_kuliah.data_index', $id_kelas_kuliah)" 
    :table="[
        ['title' => 'No.', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => 'false', 'searchable' => 'false', 'width' => '10'],                            
        ['title' => 'Nama Mahasiswa', 'data' => 'nama_mahasiswa', 'name' => 'nama_mahasiswa', 'classname' => 'text-left'],
        ['title' => 'NIM', 'data' => 'nim', 'name' => 'nim', 'classname' => 'text-left'],
        ['title' => 'Program Studi', 'data' => 'nama_program_studi', 'name' => 'nama_program_studi', 'classname' => 'text-left'],
        ['title' => 'Mata Kuliah', 'data' => 'nama_mata_kuliah', 'name' => 'nama_mata_kuliah', 'classname' => 'text-left'],
        ['title' => 'Angkatan', 'data' => 'angkatan', 'name' => 'angkatan'],
        ['title' => 'Aksi', 'data' => 'action', 'orderable' => 'false', 'searchable' => 'false'],
    ]"
    />

</x-card-table>

<x-modal.delete/>

<x-modal class="modal-form" id="modal-form">
    <x-slot name="title">Peserta Kelas Kuliah</x-slot>
    <x-slot name="modalPosition">modal-dialog-centered</x-slot>
    
    @csrf 
    @method('post')
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="id_registrasi_mahasiswa">Mahasiswa</label>
            {!! Form::select('id_registrasi_mahasiswa', $mahasiswa, null, ['class' => 'form-control '.($errors->has('id_registrasi_mahasiswa') ? 'is-invalid' : ''), 'id' => 'id_registrasi_mahasiswa']) !!}
            @error('id_registrasi_mahasiswa')
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