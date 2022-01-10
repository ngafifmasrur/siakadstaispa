@extends('layouts.app')
@section('title', 'Detail Mahasiswa')

@section('content')

<x-header>
    Detail Mahasiswa
</x-header>
<!-- Main page content-->
<div class="container mt-n10">
    <div class="row">
        <div class="col-lg-9">
            <form action="" method="post">
                <div class="card">
                    <div class="card-header">
                        Detail Mahasiswa
                    </div>
                    
                    <div class="card-body">
                        <form>
                            <div class="form-group row">
                                <label for="nim" class="col-sm-2 col-form-label">NIM</label>
                                <div class="col-sm-10">
                                {!! Form::text('nim', $mahasiswa->nim, ['class' => 'form-control '.($errors->has('nim') ? 'is-invalid' : ''), 'id' => 'nim']) !!}
                                @error('nim')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="nama_mahasiswa" class="col-sm-2 col-form-label">Nama Mahasiwa</label>
                                <div class="col-sm-10">
                                {!! Form::text('nama_mahasiswa', $mahasiswa->nama_mahasiswa, ['class' => 'form-control '.($errors->has('nama_mahasiswa') ? 'is-invalid' : ''), 'id' => 'nama_mahasiswa']) !!}
                                @error('nama_mahasiswa')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                @php
                                $jenis_kelamin = [
                                    'Laki-laki' => 'Laki-laki',
                                    'Perempuan' => 'Perempuan'
                                ];
                                @endphp
                                <label for="jenis_kelamin" class="col-sm-2 col-form-label">Nama Mahasiwa</label>
                                <div class="col-sm-10">
                                {!! Form::select('jenis_kelamin', $jenis_kelamin, $mahasiswa->jenis_kelamin, ['class' => 'form-control '.($errors->has('jenis_kelamin') ? 'is-invalid' : ''), 'id' => 'jenis_kelamin']) !!}
                                @error('jenis_kelamin')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="tanggal_lahir" class="col-sm-2 col-form-label">Tanggal Lahir</label>
                                <div class="col-sm-10">
                                    {!! Form::date('tanggal_lahir', $mahasiswa->tanggal_lahir, ['class' => 'form-control '.($errors->has('tanggal_lahir') ? 'is-invalid' : ''), 'id' => 'tanggal_lahir']) !!}
                                    @error('tanggal_lahir')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="id_agama" class="col-sm-2 col-form-label">Agama</label>
                                <div class="col-sm-10">
                                    {!! Form::select('id_agama',$agama, $mahasiswa->id_agama, ['class' => 'form-control '.($errors->has('id_agama') ? 'is-invalid' : ''), 'id' => 'id_agama']) !!}
                                    @error('id_agama')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="id_prodi" class="col-sm-2 col-form-label">Program Studi</label>
                                <div class="col-sm-10">
                                    {!! Form::select('id_prodi', $prodi, $mahasiswa->id_prodi, ['class' => 'form-control '.($errors->has('id_prodi') ? 'is-invalid' : ''), 'id' => 'id_prodi']) !!}
                                    @error('id_prodi')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                          </form>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-lg-3">
            @include('admin.mahasiswa.menu')
        </div>
    </div>

</div>
@endsection
