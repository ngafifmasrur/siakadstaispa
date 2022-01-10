@extends('layouts.app')
@section('title', 'Riwayat Pendidikan Mahasiswa')

@section('content')

<x-header>
    Riwayat Pendidikan Mahasiswa
</x-header>
<!-- Main page content-->
<div class="container mt-n10">
    <div class="row">
        <div class="col-lg-9">
            <form action="" method="post">
                <div class="card">
                    <div class="card-header">
                        Riwayat Pendidikan Mahasiswa
                        <a class="float-right btn btn-sm btn-outline-blue add-form" data-url="{{ route('admin.riwayat_pendidikan.store', ['id_mahasiswa' => $mahasiswa->id]) }}" href="#"><i data-feather="plus" class="mr-2"></i>Tambah</a>
                    </div>
                    
                    <div class="card-body">
                        @if ($errors->any())
                        <div class="alert alert-danger alert-icon" role="alert">
                            <button class="close" type="button" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                            <div class="alert-icon-content">
                                <h6 class="alert-heading">Error, Periksa Ulang data..</h6>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        @endif

                        <x-datatable 
                        :route="route('admin.riwayat_pendidikan.data_index', ['id_mahasiswa' => $mahasiswa->id])" 
                        :table="[
                            ['title' => 'No.', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => 'false', 'searchable' => 'false', 'width' => '10'],                            
                            ['title' => 'NIM', 'data' => 'nim', 'name' => 'nim'],
                            ['title' => 'Nama Mahasiswa', 'data' => 'nama_mahasiswa', 'name' => 'nama_mahasiswa', 'classname' => 'text-left'],
                            ['title' => 'Program Studi', 'data' => 'prodi', 'name' => 'prodi', 'classname' => 'text-left'],
                            ['title' => 'Periode Masuk', 'data' => 'periode', 'name' => 'periode'],
                            ['title' => 'Aksi', 'data' => 'action', 'orderable' => 'false', 'searchable' => 'false'],
                        ]"
                        />
                    </div>
                </div>
            </form>
        </div>
        <div class="col-lg-3">
            @include('admin.mahasiswa.menu')
        </div>
    </div>

</div>

<x-modal.delete/>

<x-modal class="modal-form" id="modal-form">
    <x-slot name="title">Riwayat Pendidikan Mahasiwa</x-slot>
    <x-slot name="modalPosition">modal-dialog-centered</x-slot>
    
    @csrf 
    @method('post')
    <div class="form-group row">
        <div class="form-group col-lg-6">
            <label for="nim">NIM</label>
            {!! Form::text('nim', $mahasiswa->nim, ['class' => 'form-control '.($errors->has('nim') ? 'is-invalid' : ''), 'id' => 'nim', 'readonly' => 'true']) !!}
            @error('nim')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group col-lg-6">
            <label for="nama_mahasiswa">Nama Mahasiswa</label>
            {!! Form::text('nama_mahasiswa', $mahasiswa->nama_mahasiswa, ['class' => 'form-control ', 'disabled' => 'true', 'id' => 'nama_mahasiswa']) !!}
            @error('nama_mahasiswa')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-6">
            <label for="id_jenis_daftar">Jenis Daftar</label>
            {!! Form::select('id_jenis_daftar', $jenis_daftar, null, ['class' => 'form-control '.($errors->has('id_jenis_daftar') ? 'is-invalid' : ''), 'id' => 'id_jenis_daftar']) !!}
            @error('id_jenis_daftar')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group col-lg-6">
            <label for="id_jalur_daftar">Jalur Daftar</label>
            {!! Form::select('id_jalur_daftar', $jalur_daftar, null, ['class' => 'form-control '.($errors->has('id_jalur_daftar') ? 'is-invalid' : ''), 'id' => 'id_jalur_daftar']) !!}
            @error('id_jalur_daftar')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-6">
            <label for="id_prodi">Program Studi</label>
            {!! Form::select('id_prodi', $prodi, null, ['class' => 'form-control '.($errors->has('id_prodi') ? 'is-invalid' : ''), 'id' => 'id_prodi']) !!}
            @error('id_prodi')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group col-lg-6">
            <label for="id_periode_masuk">Periode Masuk</label>
            {!! Form::select('id_periode_masuk', $periode, null, ['class' => 'form-control '.($errors->has('id_periode_masuk') ? 'is-invalid' : ''), 'id' => 'id_periode_masuk']) !!}
            @error('id_periode_masuk')
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

<x-modal class="edit-form" id="modal-form">
    <x-slot name="title">Riwayat Pendidikan Mahasiswa</x-slot>
    <x-slot name="modalPosition">modal-dialog-centered</x-slot>
    @csrf
    @method('put')
    <div class="form-group row">
        <div class="form-group col-lg-6">
            <label for="nim">NIM</label>
            {!! Form::text('nim', $mahasiswa->nim, ['class' => 'form-control '.($errors->has('nim') ? 'is-invalid' : ''), 'id' => 'nim', 'readonly' => 'true']) !!}
            @error('nim')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group col-lg-6">
            <label for="nama_mahasiswa">Nama Mahasiswa</label>
            {!! Form::text('nama_mahasiswa', $mahasiswa->nama_mahasiswa, ['class' => 'form-control ', 'disabled' => 'true', 'id' => 'nama_mahasiswa']) !!}
            @error('nama_mahasiswa')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-6">
            <label for="id_jenis_daftar">Jenis Daftar</label>
            {!! Form::select('id_jenis_daftar', $jenis_daftar, null, ['class' => 'form-control '.($errors->has('id_jenis_daftar') ? 'is-invalid' : ''), 'id' => 'id_jenis_daftar']) !!}
            @error('id_jenis_daftar')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group col-lg-6">
            <label for="id_jalur_daftar">Jalur Daftar</label>
            {!! Form::select('id_jalur_daftar', $jalur_daftar, null, ['class' => 'form-control '.($errors->has('id_jalur_daftar') ? 'is-invalid' : ''), 'id' => 'id_jalur_daftar']) !!}
            @error('id_jalur_daftar')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-6">
            <label for="id_prodi">Program Studi</label>
            {!! Form::select('id_prodi', $prodi, null, ['class' => 'form-control '.($errors->has('id_prodi') ? 'is-invalid' : ''), 'id' => 'id_prodi']) !!}
            @error('id_prodi')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group col-lg-6">
            <label for="id_periode_masuk">Periode Masuk</label>
            {!! Form::select('id_periode_masuk', $periode, null, ['class' => 'form-control '.($errors->has('id_periode_masuk') ? 'is-invalid' : ''), 'id' => 'id_periode_masuk']) !!}
            @error('id_periode_masuk')
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