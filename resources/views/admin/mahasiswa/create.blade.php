@extends('layouts.app')
@section('title', 'Input Data Mahasiswa')

@section('content')

<x-header>
    Input Data Mahasiswa
</x-header>
<!-- Main page content-->
<div class="container mt-n10">
    <div class="row">
        <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        Input Data Mahasiswa
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
                        
                        <form action="{{ route('admin.mahasiswa.store') }}" method="POST">
                            @csrf
                            <div class="form-group row">
                                <label for="nim" class="col-sm-2 col-form-label">NIM <span class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    {!! Form::text('nim', NULL, ['class' => 'form-control '.($errors->has('nim') ? 'is-invalid' : ''), 'id' => 'nim']) !!}
                                    @error('nim')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="nama_mahasiswa" class="col-sm-2 col-form-label">Nama <span class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                {!! Form::text('nama_mahasiswa', NULL, ['class' => 'form-control '.($errors->has('nama_mahasiswa') ? 'is-invalid' : ''), 'id' => 'nama_mahasiswa']) !!}
                                @error('nama_mahasiswa')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label for="nama_ibu" class="col-sm-2 col-form-label">Nama Ibu <span class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                {!! Form::text('nama_ibu', NULL, ['class' => 'form-control '.($errors->has('nama_ibu') ? 'is-invalid' : ''), 'id' => 'nama_ibu']) !!}
                                @error('nama_ibu')
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
                                <label for="jenis_kelamin" class="col-sm-2 col-form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                {!! Form::select('jenis_kelamin', $jenis_kelamin, NULL, ['class' => 'form-control '.($errors->has('jenis_kelamin') ? 'is-invalid' : ''), 'id' => 'jenis_kelamin']) !!}
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
                                    {!! Form::date('tanggal_lahir', NULL, ['class' => 'form-control '.($errors->has('tanggal_lahir') ? 'is-invalid' : ''), 'id' => 'tanggal_lahir']) !!}
                                    @error('tanggal_lahir')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="tempat_lahir" class="col-sm-2 col-form-label">Tempat Lahir <span class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    {!! Form::text('tempat_lahir', NULL, ['class' => 'form-control '.($errors->has('tempat_lahir') ? 'is-invalid' : ''), 'id' => 'tempat_lahir']) !!}
                                    @error('tempat_lahir')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="id_agama" class="col-sm-2 col-form-label">Agama <span class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    {!! Form::select('id_agama',$agama, NULL, ['class' => 'form-control '.($errors->has('id_agama') ? 'is-invalid' : ''), 'id' => 'id_agama']) !!}
                                    @error('id_agama')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="card-header border-bottom">
                                <ul class="nav nav-tabs card-header-tabs" id="cardTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="alamat-tab" href="#alamat" data-toggle="tab" role="tab" aria-controls="alamat" aria-selected="true">Alamat</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="orangtua-tab" href="#orangtua" data-toggle="tab" role="tab" aria-controls="orangtua" aria-selected="false">Orang Tua</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="wali-tab" href="#wali" data-toggle="tab" role="tab" aria-controls="wali" aria-selected="false">Wali</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="kebutuhan-tab" href="#kebutuhan" data-toggle="tab" role="tab" aria-controls="kebutuhan" aria-selected="false">Kebutuhan Khusus</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content" id="cardTabContent">
                                    <div class="tab-pane fade show active" id="alamat" role="tabpanel" aria-labelledby="alamat-tab">
                                        <div class="form-group row">
                                            <label for="nik" class="col-sm-2 col-form-label">NIK <span class="text-danger">*</span></label>
                                            <div class="col-sm-10">
                                                {!! Form::text('nik', NULL, ['class' => 'form-control '.($errors->has('nik') ? 'is-invalid' : ''), 'id' => 'nik']) !!}
                                                @error('nik')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="tempat_lahir" class="col-sm-2 col-form-label">NISN</label>
                                            <div class="col-sm-10">
                                                {!! Form::text('nisn', NULL, ['class' => 'form-control '.($errors->has('nisn') ? 'is-invalid' : ''), 'id' => 'nisn']) !!}
                                                @error('nisn')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="npwp" class="col-sm-2 col-form-label">NPWP</label>
                                            <div class="col-sm-10">
                                                {!! Form::text('npwp', NULL, ['class' => 'form-control '.($errors->has('npwp') ? 'is-invalid' : ''), 'id' => 'npwp']) !!}
                                                @error('npwp')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="kewarganegaraan" class="col-sm-2 col-form-label">Kewarganegaraan <span class="text-danger">*</span></label>
                                            <div class="col-sm-10">
                                                {!! Form::text('kewarganegaraan', NULL, ['class' => 'form-control '.($errors->has('kewarganegaraan') ? 'is-invalid' : ''), 'id' => 'kewarganegaraan']) !!}
                                                @error('kewarganegaraan')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="jalan" class="col-sm-2 col-form-label">Jalan </label>
                                            <div class="col-sm-10">
                                                {!! Form::text('jalan', NULL, ['class' => 'form-control '.($errors->has('jalan') ? 'is-invalid' : ''), 'id' => 'jalan']) !!}
                                                @error('jalan')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="dusun" class="col-sm-2 col-form-label">Dusun </label>
                                            <div class="col-sm-10">
                                                {!! Form::text('dusun', NULL, ['class' => 'form-control '.($errors->has('dusun') ? 'is-invalid' : ''), 'id' => 'dusun']) !!}
                                                @error('dusun')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="kelurahan" class="col-sm-2 col-form-label">Kelurahan <span class="text-danger">*</span></label>
                                            <div class="col-sm-10">
                                                {!! Form::text('kelurahan', NULL, ['class' => 'form-control '.($errors->has('kelurahan') ? 'is-invalid' : ''), 'id' => 'kelurahan']) !!}
                                                @error('kelurahan')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="rt" class="col-sm-2 col-form-label">RT</label>
                                            <div class="col-sm-10">
                                                {!! Form::text('rt', NULL, ['class' => 'form-control '.($errors->has('rt') ? 'is-invalid' : ''), 'id' => 'rt']) !!}
                                                @error('rt')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="rw" class="col-sm-2 col-form-label">RW</label>
                                            <div class="col-sm-10">
                                                {!! Form::text('rw', NULL, ['class' => 'form-control '.($errors->has('rw') ? 'is-invalid' : ''), 'id' => 'rw']) !!}
                                                @error('rw')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="id_wilayah" class="col-sm-2 col-form-label">Kecamatan <span class="text-danger">*</span></label>
                                            <div class="col-sm-10">
                                                {!! Form::select('id_wilayah', $wilayah, NULL, ['class' => 'form-control '.($errors->has('id_wilayah') ? 'is-invalid' : ''), 'id' => 'id_wilayah']) !!}
                                                @error('id_wilayah')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="kode_pos" class="col-sm-2 col-form-label">Kode Pos</label>
                                            <div class="col-sm-10">
                                                {!! Form::text('kode_pos', NULL, ['class' => 'form-control '.($errors->has('kode_pos') ? 'is-invalid' : ''), 'id' => 'kode_pos']) !!}
                                                @error('kode_pos')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="id_jenis_tinggal" class="col-sm-2 col-form-label">Jenis Tinggal</label>
                                            <div class="col-sm-10">
                                                {!! Form::select('id_jenis_tinggal', $jenis_tinggal, NULL, ['class' => 'form-control '.($errors->has('id_jenis_tinggal') ? 'is-invalid' : ''), 'id' => 'id_jenis_tinggal']) !!}
                                                @error('id_jenis_tinggal')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="id_alat_transportasi" class="col-sm-2 col-form-label">Alat Transportasi</label>
                                            <div class="col-sm-10">
                                                {!! Form::select('id_alat_transportasi', $alat_transportasi, NULL, ['class' => 'form-control '.($errors->has('id_alat_transportasi') ? 'is-invalid' : ''), 'id' => 'id_alat_transportasi']) !!}
                                                @error('id_alat_transportasi')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="telepon" class="col-sm-2 col-form-label">Telepon</label>
                                            <div class="col-sm-10">
                                                {!! Form::text('telepon', NULL, ['class' => 'form-control '.($errors->has('telepon') ? 'is-invalid' : ''), 'id' => 'telepon']) !!}
                                                @error('telepon')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="handphone" class="col-sm-2 col-form-label">HP</label>
                                            <div class="col-sm-10">
                                                {!! Form::text('handphone', NULL, ['class' => 'form-control '.($errors->has('handphone') ? 'is-invalid' : ''), 'id' => 'handphone']) !!}
                                                @error('handphone')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="email" class="col-sm-2 col-form-label">Email</label>
                                            <div class="col-sm-10">
                                                {!! Form::email('email', NULL, ['class' => 'form-control '.($errors->has('email') ? 'is-invalid' : ''), 'id' => 'email']) !!}
                                                @error('email')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="penerima_kps" class="col-sm-2 col-form-label">Penerima KPS  <span class="text-danger">*</span></label>
                                            <div class="col-sm-10">
                                                {!! Form::select('penerima_kps', [1 => 'Ya', 0 => 'Tidak'], NULL, ['class' => 'form-control '.($errors->has('penerima_kps') ? 'is-invalid' : ''), 'id' => 'penerima_kps']) !!}
                                                @error('penerima_kps')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="no_kps" class="col-sm-2 col-form-label">No KPS </label>
                                            <div class="col-sm-10">
                                                {!! Form::text('no_kps', NULL, ['class' => 'form-control '.($errors->has('no_kps') ? 'is-invalid' : ''), 'id' => 'no_kps']) !!}
                                                @error('no_kps')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="orangtua" role="tabpanel" aria-labelledby="orangtua-tab">
                                        <div class="form-group row">
                                            <label for="nama_ibu_kandung" class="col-sm-2 col-form-label">Nama Ibu Kandung  <span class="text-danger">*</span></label>
                                            <div class="col-sm-10">
                                                {!! Form::text('nama_ibu_kandung', NULL, ['class' => 'form-control '.($errors->has('nama_ibu_kandung') ? 'is-invalid' : ''), 'id' => 'nama_ibu_kandung']) !!}
                                                @error('nama_ibu_kandung')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="tanggal_lahir_ibu" class="col-sm-2 col-form-label">Tanggal Lahir Ibu</label>
                                            <div class="col-sm-10">
                                                {!! Form::date('tanggal_lahir_ibu', NULL, ['class' => 'form-control '.($errors->has('tanggal_lahir_ibu') ? 'is-invalid' : ''), 'id' => 'tanggal_lahir_ibu']) !!}
                                                @error('tanggal_lahir_ibu')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="nik_ibu" class="col-sm-2 col-form-label">NIK Ibu</label>
                                            <div class="col-sm-10">
                                                {!! Form::text('nik_ibu', NULL, ['class' => 'form-control '.($errors->has('nik_ibu') ? 'is-invalid' : ''), 'id' => 'nik_ibu']) !!}
                                                @error('nik_ibu')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="id_jenjang_pendidikan_ibu" class="col-sm-2 col-form-label">Jenjang Pendidikan Ibu</label>
                                            <div class="col-sm-10">
                                                {!! Form::select('id_jenjang_pendidikan_ibu', $jenjang_pendidikan, NULL, ['class' => 'form-control '.($errors->has('id_jenjang_pendidikan_ibu') ? 'is-invalid' : ''), 'id' => 'id_jenjang_pendidikan_ibu']) !!}
                                                @error('id_jenjang_pendidikan_ibu')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="id_pekerjaan_ibu" class="col-sm-2 col-form-label">Pekerjaan Ibu</label>
                                            <div class="col-sm-10">
                                                {!! Form::select('id_pekerjaan_ibu', $pekerjaan, NULL, ['class' => 'form-control '.($errors->has('id_pekerjaan_ibu') ? 'is-invalid' : ''), 'id' => 'id_pekerjaan_ibu']) !!}
                                                @error('id_pekerjaan_ibu')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="id_penghasilan_ibu" class="col-sm-2 col-form-label">Penghasilan Ibu</label>
                                            <div class="col-sm-10">
                                                {!! Form::select('id_penghasilan_ibu', $penghasilan, NULL, ['class' => 'form-control '.($errors->has('id_penghasilan_ibu') ? 'is-invalid' : ''), 'id' => 'id_penghasilan_ibu']) !!}
                                                @error('id_penghasilan_ibu')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="nama_ayah_kandung" class="col-sm-2 col-form-label">Nama Ayah  <span class="text-danger">*</span></label>
                                            <div class="col-sm-10">
                                                {!! Form::text('nama_ayah', NULL, ['class' => 'form-control '.($errors->has('nama_ayah') ? 'is-invalid' : ''), 'id' => 'nama_ayah']) !!}
                                                @error('nama_ayah_kandung')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="tanggal_lahir_ayah" class="col-sm-2 col-form-label">Tanggal Lahir Ayah</label>
                                            <div class="col-sm-10">
                                                {!! Form::date('tanggal_lahir_ayah', NULL, ['class' => 'form-control '.($errors->has('tanggal_lahir_ayah') ? 'is-invalid' : ''), 'id' => 'tanggal_lahir_ayah']) !!}
                                                @error('tanggal_lahir_ayah')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="nik_ayah" class="col-sm-2 col-form-label">NIK Ayah</label>
                                            <div class="col-sm-10">
                                                {!! Form::text('nik_ayah', NULL, ['class' => 'form-control '.($errors->has('nik_ayah') ? 'is-invalid' : ''), 'id' => 'nik_ayah']) !!}
                                                @error('nik_ayah')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="id_jenjang_pendidikan_ayah" class="col-sm-2 col-form-label">Jenjang Pendidikan Ayah</label>
                                            <div class="col-sm-10">
                                                {!! Form::select('id_jenjang_pendidikan_ayah', $jenjang_pendidikan, NULL, ['class' => 'form-control '.($errors->has('id_jenjang_pendidikan_ayah') ? 'is-invalid' : ''), 'id' => 'id_jenjang_pendidikan_ayah']) !!}
                                                @error('id_jenjang_pendidikan_ayah')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="id_pekerjaan_ayah" class="col-sm-2 col-form-label">Pekerjaan Ayah</label>
                                            <div class="col-sm-10">
                                                {!! Form::select('id_pekerjaan_ayah', $pekerjaan, NULL, ['class' => 'form-control '.($errors->has('id_pekerjaan_ayah') ? 'is-invalid' : ''), 'id' => 'id_pekerjaan_ayah']) !!}
                                                @error('id_pekerjaan_ayah')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="id_penghasilan_ayah" class="col-sm-2 col-form-label">Penghasilan Ayah</label>
                                            <div class="col-sm-10">
                                                {!! Form::select('id_penghasilan_ayah', $penghasilan, NULL, ['class' => 'form-control '.($errors->has('id_penghasilan_ayah') ? 'is-invalid' : ''), 'id' => 'id_penghasilan_ayah']) !!}
                                                @error('id_penghasilan_ayah')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="wali" role="tabpanel" aria-labelledby="wali-tab">
                                        <div class="form-group row">
                                            <label for="nama_wali" class="col-sm-2 col-form-label">Nama Wali</label>
                                            <div class="col-sm-10">
                                                {!! Form::text('nama_wali', NULL, ['class' => 'form-control '.($errors->has('nama_wali') ? 'is-invalid' : ''), 'id' => 'nama_wali']) !!}
                                                @error('nama_wali_kandung')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="tanggal_lahir_wali" class="col-sm-2 col-form-label">Tanggal Lahir Wali</label>
                                            <div class="col-sm-10">
                                                {!! Form::date('tanggal_lahir_wali', NULL, ['class' => 'form-control '.($errors->has('tanggal_lahir_wali') ? 'is-invalid' : ''), 'id' => 'tanggal_lahir_wali']) !!}
                                                @error('tanggal_lahir_wali')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="nik_wali" class="col-sm-2 col-form-label">NIK Wali</label>
                                            <div class="col-sm-10">
                                                {!! Form::text('nik_wali', NULL, ['class' => 'form-control '.($errors->has('nik_wali') ? 'is-invalid' : ''), 'id' => 'nik_wali']) !!}
                                                @error('nik_wali')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="id_jenjang_pendidikan_wali" class="col-sm-2 col-form-label">Jenjang Pendidikan Wali</label>
                                            <div class="col-sm-10">
                                                {!! Form::select('id_jenjang_pendidikan_wali', $jenjang_pendidikan, NULL, ['class' => 'form-control '.($errors->has('id_jenjang_pendidikan_wali') ? 'is-invalid' : ''), 'id' => 'id_jenjang_pendidikan_wali']) !!}
                                                @error('id_jenjang_pendidikan_wali')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="id_pekerjaan_wali" class="col-sm-2 col-form-label">Pekerjaan Wali</label>
                                            <div class="col-sm-10">
                                                {!! Form::select('id_pekerjaan_wali', $pekerjaan, NULL, ['class' => 'form-control '.($errors->has('id_pekerjaan_wali') ? 'is-invalid' : ''), 'id' => 'id_pekerjaan_wali']) !!}
                                                @error('id_pekerjaan_wali')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="id_penghasilan_wali" class="col-sm-2 col-form-label">Penghasilan Wali</label>
                                            <div class="col-sm-10">
                                                {!! Form::select('id_penghasilan_wali', $penghasilan, NULL, ['class' => 'form-control '.($errors->has('id_penghasilan_wali') ? 'is-invalid' : ''), 'id' => 'id_penghasilan_wali']) !!}
                                                @error('id_penghasilan_wali')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                    </div>
                                    <div class="tab-pane fade" id="kebutuhan" role="tabpanel" aria-labelledby="kebutuhan-tab">
                                        <div class="form-group row">
                                            <label for="id_kebutuhan_khusus_mahasiswa" class="col-sm-2 col-form-label">Kebutuhan Khusus Mahasiswa</label>
                                            <div class="col-sm-10">
                                                {!! Form::select('id_kebutuhan_khusus_mahasiswa', $kebutuhan_khusus, NULL, ['class' => 'form-control '.($errors->has('id_kebutuhan_khusus_mahasiswa') ? 'is-invalid' : ''), 'id' => 'id_kebutuhan_khusus_mahasiswa']) !!}
                                                @error('id_kebutuhan_khusus_mahasiswa')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="id_kebutuhan_khusus_ibu" class="col-sm-2 col-form-label">Kebutuhan Khusus Ibu</label>
                                            <div class="col-sm-10">
                                                {!! Form::select('id_kebutuhan_khusus_ibu', $kebutuhan_khusus, NULL, ['class' => 'form-control '.($errors->has('id_kebutuhan_khusus_ibu') ? 'is-invalid' : ''), 'id' => 'id_kebutuhan_khusus_ibu']) !!}
                                                @error('id_kebutuhan_khusus_ibu')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="id_kebutuhan_khusus_ayah" class="col-sm-2 col-form-label">Kebutuhan Khusus Ayah</label>
                                            <div class="col-sm-10">
                                                {!! Form::select('id_kebutuhan_khusus_ayah', $kebutuhan_khusus, NULL, ['class' => 'form-control '.($errors->has('id_kebutuhan_khusus_ayah') ? 'is-invalid' : ''), 'id' => 'id_kebutuhan_khusus_ayah']) !!}
                                                @error('id_kebutuhan_khusus_ayah')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button class="float-right btn btn-primary" type="submit">Simpan</button>

                          </form>
                    </div>
                </div>
        </div>
    </div>

</div>
@endsection
