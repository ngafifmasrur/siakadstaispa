@extends('layouts.app')
@section('title', 'Mahasiswa')

@section('content')

<x-header>
    Mahasiswa
</x-header>
<!-- Main page content-->
<div class="container mt-n10">
    <div class="row">
        <div class="col-lg-12">
            <form action="" method="post">
                <div class="card">
                    <div class="card-header">
                        Data Mahasiswa
                        <a class="float-right btn btn-sm btn-outline-blue add-form" data-url="{{ route('admin.mahasiswa.store') }}" href="#"><i data-feather="plus" class="mr-2"></i>Tambah</a>
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
                        :route="route('admin.mahasiswa.data_index')" 
                        :table="[
                            ['title' => 'No.', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => 'false', 'searchable' => 'false', 'width' => '10'],                            
                            ['title' => 'NIM', 'data' => 'nim', 'name' => 'nim'],
                            ['title' => 'Nama Mahasiswa', 'data' => 'nama_mahasiswa', 'name' => 'nama_mahasiswa', 'classname' => 'text-left'],
                            ['title' => 'Jenis Kelamin', 'data' => 'jenis_kelamin', 'name' => 'jenis_kelamin'],
                            ['title' => 'Tanggal Lahir', 'data' => 'tanggal_lahir', 'name' => 'tanggal_lahir'],
                            ['title' => 'Agama', 'data' => 'agama', 'name' => 'agama'],
                            ['title' => 'Program Studi', 'data' => 'prodi', 'name' => 'prodi', 'classname' => 'text-left'],
                            ['title' => 'Periode', 'data' => 'periode', 'name' => 'periode'],
                            ['title' => 'Aksi', 'data' => 'action', 'orderable' => 'false', 'searchable' => 'false'],
                        ]"
                        />
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>

<x-modal.delete/>

<x-modal class="modal-form" id="modal-form">
    <x-slot name="title">Mahasiwa</x-slot>
    <x-slot name="modalPosition">modal-dialog-centered</x-slot>
    
    @csrf 
    @method('post')
    <div class="form-group row">
        <div class="form-group col-lg-6">
            <label for="nim">NIM</label>
            {!! Form::text('nim', null, ['class' => 'form-control '.($errors->has('nim') ? 'is-invalid' : ''), 'id' => 'nim']) !!}
            @error('nim')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group col-lg-6">
            <label for="nama_mahasiswa">Nama Mahasiswa</label>
            {!! Form::text('nama_mahasiswa', null, ['class' => 'form-control '.($errors->has('tanggal_selesai_efektif') ? 'is-invalid' : ''), 'id' => 'nama_mahasiswa']) !!}
            @error('nama_mahasiswa')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    @php
        $jenis_kelamin = [
            'Laki-laki' => 'Laki-laki',
            'Perempuan' => 'Perempuan'
        ];
    @endphp
    <div class="form-group row">
        <div class="form-group col-lg-4">
            <label for="jenis_kelamin">Jenis Kelamin</label>
            {!! Form::select('jenis_kelamin', $jenis_kelamin, null, ['class' => 'form-control '.($errors->has('jenis_kelamin') ? 'is-invalid' : ''), 'id' => 'jenis_kelamin']) !!}
            @error('jenis_kelamin')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group col-lg-4">
            <label for="tanggal_lahir">Tanggal Lahir</label>
            {!! Form::date('tanggal_lahir', null, ['class' => 'form-control '.($errors->has('tanggal_lahir') ? 'is-invalid' : ''), 'id' => 'tanggal_lahir']) !!}
            @error('tanggal_lahir')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group col-lg-4">
            <label for="id_agama">Agama</label>
            {!! Form::select('id_agama',$agama, null, ['class' => 'form-control '.($errors->has('id_agama') ? 'is-invalid' : ''), 'id' => 'id_agama']) !!}
            @error('id_agama')
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
            <label for="id_periode">Periode</label>
            {!! Form::select('id_periode', $periode, null, ['class' => 'form-control '.($errors->has('id_periode') ? 'is-invalid' : ''), 'id' => 'id_periode']) !!}
            @error('id_periode')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-6">
            <label for="id_status_mahasiswa">Status Mahasiswa</label>
            {!! Form::select('id_status_mahasiswa', $status_mahasiswa, null, ['class' => 'form-control '.($errors->has('id_status_mahasiswa') ? 'is-invalid' : ''), 'id' => 'id_status_mahasiswa']) !!}
            @error('id_status_mahasiswa')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group col-lg-6">
            <label for="password">Password Akun</label>
            <input type="password" name="password" class="form-control {{$errors->has('password') ? 'is-invalid' : ''}}">
            @error('password')
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
    <x-slot name="title">Mahasiswa</x-slot>
    <x-slot name="modalPosition">modal-dialog-centered</x-slot>
    @csrf
    @method('put')
    <div class="form-group row">
        <div class="form-group col-lg-6">
            <label for="nim">NIM</label>
            {!! Form::text('nim', null, ['class' => 'form-control '.($errors->has('nim') ? 'is-invalid' : ''), 'id' => 'nim']) !!}
            @error('nim')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group col-lg-6">
            <label for="nama_mahasiswa">Nama Mahasiswa</label>
            {!! Form::text('nama_mahasiswa', null, ['class' => 'form-control '.($errors->has('tanggal_selesai_efektif') ? 'is-invalid' : ''), 'id' => 'nama_mahasiswa']) !!}
            @error('nama_mahasiswa')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    @php
        $jenis_kelamin = [
            'Laki-laki' => 'Laki-laki',
            'Perempuan' => 'Perempuan'
        ];
    @endphp
    <div class="form-group row">
        <div class="form-group col-lg-4">
            <label for="jenis_kelamin">Jenis Kelamin</label>
            {!! Form::select('jenis_kelamin', $jenis_kelamin, null, ['class' => 'form-control '.($errors->has('jenis_kelamin') ? 'is-invalid' : ''), 'id' => 'jenis_kelamin']) !!}
            @error('jenis_kelamin')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group col-lg-4">
            <label for="tanggal_lahir">Tanggal Lahir</label>
            {!! Form::date('tanggal_lahir', null, ['class' => 'form-control '.($errors->has('tanggal_lahir') ? 'is-invalid' : ''), 'id' => 'tanggal_lahir']) !!}
            @error('tanggal_lahir')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group col-lg-4">
            <label for="id_agama">Agama</label>
            {!! Form::select('id_agama',$agama, null, ['class' => 'form-control '.($errors->has('id_agama') ? 'is-invalid' : ''), 'id' => 'id_agama']) !!}
            @error('id_agama')
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
            <label for="id_periode">Periode</label>
            {!! Form::select('id_periode', $periode, null, ['class' => 'form-control '.($errors->has('id_periode') ? 'is-invalid' : ''), 'id' => 'id_semester']) !!}
            @error('id_periode')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-6">
            <label for="id_status_mahasiswa">Status Mahasiswa</label>
            {!! Form::select('id_status_mahasiswa', $status_mahasiswa, null, ['class' => 'form-control '.($errors->has('id_status_mahasiswa') ? 'is-invalid' : ''), 'id' => 'id_status_mahasiswa']) !!}
            @error('id_status_mahasiswa')
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
            var id_prodi = $(this).data('prodi');
            var id_periode = $(this).data('periode');
            var id_semester = $(this).data('semester');
            var nama_mahasiswa = $(this).data('nama');
            var id_status_mahasiswa = $(this).data('id_status_mahasiswa');
            var nim = $(this).data('nim');

            $('[name=id_prodi]').val(id_prodi);
            $('[name=id_periode]').val(id_periode);
            $('[name=nama_mahasiswa]').val(nama_mahasiswa);
            $('[name=tanggal_lahir]').val(tanggal_lahir);
            $('[name=id_agama]').val(id_agama);
            $('[name=id_status_mahasiswa]').val(id_status_mahasiswa);
            $('[name=nim]').val(nim);

        });
    </script>
@endpush