@extends('layouts.app')
@section('title', 'Ubah Biodata Dosen')

@section('content')

<x-header>
    Ubah Biodata Dosen
</x-header>

<x-card-table>
    <x-slot name="title">Ubah Biodata Dosen</x-slot>

    <form action="{{ route('dosen.biodata.update') }}" method="POST">
        @csrf @method('PUT')
        <div class="form-group row">
            <label for="nidn" class="col-sm-2 col-form-label">NIDN <span class="text-danger">*</span></label>
            <div class="col-sm-10">
                {!! Form::text('nidn', $dosen->nidn, ['class' => 'form-control '.($errors->has('nidn') ? 'is-invalid' : ''), 'id' => 'nidn']) !!}
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
            {!! Form::text('nama_dosen', $dosen->nama_dosen, ['class' => 'form-control '.($errors->has('nama_dosen') ? 'is-invalid' : ''), 'id' => 'nama_dosen']) !!}
            @error('nama_dosen')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
            </div>
        </div>
        
        <div class="form-group row">
            <label for="nama_ibu" class="col-sm-2 col-form-label">Nama Ibu <span class="text-danger">*</span></label>
            <div class="col-sm-10">
            {!! Form::text('nama_ibu', $dosen->nama_ibu, ['class' => 'form-control '.($errors->has('nama_ibu') ? 'is-invalid' : ''), 'id' => 'nama_ibu']) !!}
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
            {!! Form::select('jenis_kelamin', $jenis_kelamin, $dosen->jenis_kelamin, ['class' => 'form-control '.($errors->has('jenis_kelamin') ? 'is-invalid' : ''), 'id' => 'jenis_kelamin']) !!}
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
                {!! Form::date('tanggal_lahir', $dosen->tanggal_lahir, ['class' => 'form-control '.($errors->has('tanggal_lahir') ? 'is-invalid' : ''), 'id' => 'tanggal_lahir']) !!}
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
                {!! Form::text('tempat_lahir', $dosen->tempat_lahir, ['class' => 'form-control '.($errors->has('tempat_lahir') ? 'is-invalid' : ''), 'id' => 'tempat_lahir']) !!}
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
                {!! Form::select('id_agama',$agama, $dosen->id_agama, ['class' => 'form-control '.($errors->has('id_agama') ? 'is-invalid' : ''), 'id' => 'id_agama']) !!}
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
                            {!! Form::text('nik', $dosen->nik, ['class' => 'form-control '.($errors->has('nik') ? 'is-invalid' : ''), 'id' => 'nik']) !!}
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
                            {!! Form::text('nip', $dosen->nip, ['class' => 'form-control '.($errors->has('nip') ? 'is-invalid' : ''), 'id' => 'nip']) !!}
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
                            {!! Form::text('npwp', $dosen->npwp, ['class' => 'form-control '.($errors->has('npwp') ? 'is-invalid' : ''), 'id' => 'npwp']) !!}
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
                            {!! Form::text('jalan', $dosen->jalan, ['class' => 'form-control '.($errors->has('jalan') ? 'is-invalid' : ''), 'id' => 'jalan']) !!}
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
                            {!! Form::text('dusun', $dosen->dusun, ['class' => 'form-control '.($errors->has('dusun') ? 'is-invalid' : ''), 'id' => 'dusun']) !!}
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
                            {!! Form::text('ds_kel', $dosen->ds_kel, ['class' => 'form-control '.($errors->has('ds_kel') ? 'is-invalid' : ''), 'id' => 'ds_kel']) !!}
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
                            {!! Form::text('rt', $dosen->rt, ['class' => 'form-control '.($errors->has('rt') ? 'is-invalid' : ''), 'id' => 'rt']) !!}
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
                            {!! Form::text('rw', $dosen->rw, ['class' => 'form-control '.($errors->has('rw') ? 'is-invalid' : ''), 'id' => 'rw']) !!}
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
                            {!! Form::select('id_wilayah', $wilayah, $dosen->id_wilayah, ['class' => 'form-control '.($errors->has('id_wilayah') ? 'is-invalid' : ''), 'id' => 'id_wilayah']) !!}
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
                            {!! Form::text('kode_pos', $dosen->kode_pos, ['class' => 'form-control '.($errors->has('kode_pos') ? 'is-invalid' : ''), 'id' => 'kode_pos']) !!}
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
                            {!! Form::text('telepon', $dosen->telepon, ['class' => 'form-control '.($errors->has('telepon') ? 'is-invalid' : ''), 'id' => 'telepon']) !!}
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
                            {!! Form::text('handphone', $dosen->handphone, ['class' => 'form-control '.($errors->has('handphone') ? 'is-invalid' : ''), 'id' => 'handphone']) !!}
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
                            {!! Form::email('email', $dosen->email, ['class' => 'form-control '.($errors->has('email') ? 'is-invalid' : ''), 'id' => 'email']) !!}
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
                        <label for="mampu_handle_kebutuhan_khusus" class="col-sm-2 col-form-label">Mampu Handle Kebutuhan Khusus</label>
                        <div class="col-sm-10">
                            {!! Form::select('mampu_handle_kebutuhan_khusus', [1 => 'Ya', 0 => 'Tidak'], $dosen->mampu_handle_kebutuhan_khusus, ['class' => 'form-control '.($errors->has('mampu_handle_kebutuhan_khusus') ? 'is-invalid' : ''), 'id' => 'mampu_handle_kebutuhan_khusus']) !!}
                            @error('mampu_handle_kebutuhan_khusus')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="mampu_handle_braille" class="col-sm-2 col-form-label">Mampu Handle Braile</label>
                        <div class="col-sm-10">
                            {!! Form::select('mampu_handle_braille', [1 => 'Ya', 0 => 'Tidak'], $dosen->mampu_handle_braille, ['class' => 'form-control '.($errors->has('mampu_handle_braille') ? 'is-invalid' : ''), 'id' => 'mampu_handle_braille']) !!}
                            @error('mampu_handle_braille')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="mampu_handle_bahasa_isyarat" class="col-sm-2 col-form-label">Mampu Bahasa Isyarat</label>
                        <div class="col-sm-10">
                            {!! Form::select('mampu_handle_bahasa_isyarat', [1 => 'Ya', 0 => 'Tidak'], $dosen->mampu_handle_bahasa_isyarat, ['class' => 'form-control '.($errors->has('mampu_handle_bahasa_isyarat') ? 'is-invalid' : ''), 'id' => 'mampu_handle_bahasa_isyarat']) !!}
                            @error('mampu_handle_bahasa_isyarat')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="id_jenis_sdm" class="col-sm-2 col-form-label">Jenis SDM</label>
                        <div class="col-sm-10">
                            {!! Form::select('id_jenis_sdm', [12 => 'Dosen'], 12, ['class' => 'form-control '.($errors->has('mampu_handle_bahasa_isyarat') ? 'is-invalid' : ''), 'id' => 'id_jenis_sdm']) !!}
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
                            {!! Form::select('id_status_aktif', [1 => 'Aktif', 0 => 'Tidak Aktif'], NULL, ['class' => 'form-control '.($errors->has('id_status_aktif') ? 'is-invalid' : ''), 'id' => 'id_status_aktif']) !!}
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
@endpush
