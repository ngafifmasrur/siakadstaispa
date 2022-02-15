@extends('layouts.app')
@section('title', 'Ubah Data Dosen')

@section('content')

<x-header>
    Ubah Data Dosen
</x-header>

<x-card-table>
    <x-slot name="title">Ubah Data Dosen</x-slot>

    <form action="{{ route('admin.dosen_belum_nidn.update', $dosen_belum_nidn->id_dosen) }}" method="POST">
        @csrf @method('PUT')
        <div class="form-group row">
            <label for="nidn" class="col-sm-2 col-form-label">NIDN</label>
            <div class="col-sm-10">
                {!! Form::text('nidn', $dosen_belum_nidn->nidn, ['class' => 'form-control '.($errors->has('nidn') ? 'is-invalid' : ''), 'id' => 'nidn']) !!}
                @error('nidn')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label for="nama_dosen" class="col-sm-2 col-form-label">Nama <span class="text-danger">*</span></label>
            <div class="col-sm-10">
            {!! Form::text('nama_dosen', $dosen_belum_nidn->nama_dosen, ['class' => 'form-control '.($errors->has('nama_dosen') ? 'is-invalid' : ''), 'id' => 'nama_dosen']) !!}
            @error('nama_dosen')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
            </div>
        </div>
        
        <div class="form-group row">
            <label for="nama_ibu" class="col-sm-2 col-form-label">Nama Ibu Kandung<span class="text-danger">*</span></label>
            <div class="col-sm-10">
            {!! Form::text('nama_ibu_kandung', $dosen_belum_nidn->nama_ibu_kandung, ['class' => 'form-control '.($errors->has('nama_ibu_kandung') ? 'is-invalid' : ''), 'id' => 'nama_ibu_kandung']) !!}
            @error('nama_ibu_kandung')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
            </div>
        </div>
        
        <div class="form-group row">
            @php
            $jenis_kelamin = [
                'L' => 'Laki-laki',
                'P' => 'Perempuan'
            ];
            @endphp
            <label for="jenis_kelamin" class="col-sm-2 col-form-label">Jenis Kelamin <span class="text-danger">*</span></label>
            <div class="col-sm-10">
            {!! Form::select('jenis_kelamin', $jenis_kelamin, $dosen_belum_nidn->jenis_kelamin, ['class' => 'form-control '.($errors->has('jenis_kelamin') ? 'is-invalid' : ''), 'id' => 'jenis_kelamin']) !!}
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
                {!! Form::date('tanggal_lahir', $dosen_belum_nidn->tanggal_lahir, ['class' => 'form-control '.($errors->has('tanggal_lahir') ? 'is-invalid' : ''), 'id' => 'tanggal_lahir']) !!}
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
                {!! Form::text('tempat_lahir', $dosen_belum_nidn->tempat_lahir, ['class' => 'form-control '.($errors->has('tempat_lahir') ? 'is-invalid' : ''), 'id' => 'tempat_lahir']) !!}
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
                {!! Form::select('id_agama',$agama, $dosen_belum_nidn->id_agama, ['class' => 'form-control '.($errors->has('id_agama') ? 'is-invalid' : ''), 'id' => 'id_agama']) !!}
                @error('id_agama')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>

        <div class="card-header border-bottom">
            <div class="tabs-menu1 ">
                <ul class="nav panel-tabs" id="cardTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="alamat-tab" href="#alamat" data-toggle="tab" role="tab" aria-controls="alamat" aria-selected="true">Alamat</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="other-tab" href="#other" data-toggle="tab" role="tab" aria-controls="other" aria-selected="false">Lainnya</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="card-body">
            <div class="tab-content" id="cardTabContent">
                <div class="tab-pane fade show active" id="alamat" role="tabpanel" aria-labelledby="alamat-tab">
                    <div class="form-group row">
                        <label for="nik" class="col-sm-2 col-form-label">NIK <span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            {!! Form::text('nik', $dosen_belum_nidn->nik, ['class' => 'form-control '.($errors->has('nik') ? 'is-invalid' : ''), 'id' => 'nik']) !!}
                            @error('nik')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nip" class="col-sm-2 col-form-label">NIP</label>
                        <div class="col-sm-10">
                            {!! Form::text('nip', $dosen_belum_nidn->nip, ['class' => 'form-control '.($errors->has('nip') ? 'is-invalid' : ''), 'id' => 'nip']) !!}
                            @error('nip')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="npwp" class="col-sm-2 col-form-label">NPWP</label>
                        <div class="col-sm-10">
                            {!! Form::text('npwp', $dosen_belum_nidn->npwp, ['class' => 'form-control '.($errors->has('npwp') ? 'is-invalid' : ''), 'id' => 'npwp']) !!}
                            @error('npwp')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="jalan" class="col-sm-2 col-form-label">Jalan </label>
                        <div class="col-sm-10">
                            {!! Form::text('jalan', $dosen_belum_nidn->jalan, ['class' => 'form-control '.($errors->has('jalan') ? 'is-invalid' : ''), 'id' => 'jalan']) !!}
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
                            {!! Form::text('dusun', $dosen_belum_nidn->dusun, ['class' => 'form-control '.($errors->has('dusun') ? 'is-invalid' : ''), 'id' => 'dusun']) !!}
                            @error('dusun')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="ds_kel" class="col-sm-2 col-form-label">Kelurahan <span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            {!! Form::text('ds_kel', $dosen_belum_nidn->ds_kel, ['class' => 'form-control '.($errors->has('ds_kel') ? 'is-invalid' : ''), 'id' => 'ds_kel']) !!}
                            @error('ds_kel')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="rt" class="col-sm-2 col-form-label">RT</label>
                        <div class="col-sm-10">
                            {!! Form::text('rt', $dosen_belum_nidn->rt, ['class' => 'form-control '.($errors->has('rt') ? 'is-invalid' : ''), 'id' => 'rt']) !!}
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
                            {!! Form::text('rw', $dosen_belum_nidn->rw, ['class' => 'form-control '.($errors->has('rw') ? 'is-invalid' : ''), 'id' => 'rw']) !!}
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
                            {!! Form::select('id_wilayah', $wilayah, $dosen_belum_nidn->id_wilayah, ['class' => 'form-control '.($errors->has('id_wilayah') ? 'is-invalid' : ''), 'id' => 'id_wilayah']) !!}
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
                            {!! Form::text('kode_pos', $dosen_belum_nidn->kode_pos, ['class' => 'form-control '.($errors->has('kode_pos') ? 'is-invalid' : ''), 'id' => 'kode_pos']) !!}
                            @error('kode_pos')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="telepon" class="col-sm-2 col-form-label">Telepon <span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            {!! Form::text('telepon', $dosen_belum_nidn->telepon, ['class' => 'form-control '.($errors->has('telepon') ? 'is-invalid' : ''), 'id' => 'telepon']) !!}
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
                            {!! Form::text('handphone', $dosen_belum_nidn->handphone, ['class' => 'form-control '.($errors->has('handphone') ? 'is-invalid' : ''), 'id' => 'handphone']) !!}
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
                            {!! Form::email('email', $dosen_belum_nidn->email, ['class' => 'form-control '.($errors->has('email') ? 'is-invalid' : ''), 'id' => 'email']) !!}
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="other" role="tabpanel" aria-labelledby="other-tab">
                <div class="form-group row">
                    <label for="status_pernikahan" class="col-sm-2 col-form-label">Status Pernikahan</label>
                    <div class="col-sm-10">
                        {!! Form::select('status_pernikahan', [1 => 'Belum Menikah', 1 => 'Menikah'], $dosen_belum_nidn->status_pernikahan, ['class' => 'form-control '.($errors->has('status_pernikahan') ? 'is-invalid' : ''), 'id' => 'status_pernikahan']) !!}
                        @error('status_pernikahan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                    <div class="form-group row">
                        <label for="id_jenis_sdm" class="col-sm-2 col-form-label">Jenis SDM</label>
                        <div class="col-sm-10">
                            {!! Form::select('id_jenis_sdm', $ikatan_sdm, $dosen_belum_nidn->id_jenis_sdm, ['class' => 'form-control '.($errors->has('id_jenis_sdm') ? 'is-invalid' : ''), 'id' => 'id_jenis_sdm']) !!}
                            @error('id_jenis_sdm')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="id_status_aktif" class="col-sm-2 col-form-label">Status Aktif</label>
                        <div class="col-sm-10">
                            {!! Form::select('id_status_aktif', [1 => 'Aktif', 0 => 'Tidak Aktif'], $dosen_belum_nidn->id_status_aktif, ['class' => 'form-control '.($errors->has('id_status_aktif') ? 'is-invalid' : ''), 'id' => 'id_status_aktif']) !!}
                            @error('id_status_aktif')
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
</x-card-table>
@endsection

@push('css')
    <style>
        .form-group {
            display: flex!important;
        }
    </style>
    <link href="{{ asset('sparic/plugins/tabs/tabs-style.css') }}" rel="stylesheet" />
@endpush

@push('js')
    <script src="{{ asset('sparic/plugins/tabs/jquery.multipurpose_tabcontent.js') }}"></script>
    <script src="{{ asset('sparic/plugins/tabs/tabs.js') }}"></script>
@endpush