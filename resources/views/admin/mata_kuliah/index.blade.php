@extends('layouts.app')
@section('title', 'Mata Kuliah')

@section('content')
<header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
    <div class="container">
        <div class="page-header-content pt-4">
            <div class="row align-items-center justify-content-between">
                <div class="col-auto mt-4">
                    <h1 class="page-header-title">
                        <div class="page-header-icon"><i data-feather="grid"></i></div>
                        Mata Kuliah
                    </h1>
                    {{-- <div class="page-header-subtitle">Example dashboard overview and content summary</div> --}}
                </div>
            </div>
        </div>
    </div>
</header>
<!-- Main page content-->
<div class="container mt-n10">
    <div class="row">
        <div class="col-lg-12">
            <form action="" method="post">
                <div class="card">
                    <div class="card-header">
                        Data Mata Kuliah
                        <a class="float-right btn btn-sm btn-outline-blue add-form" data-url="{{ route('admin.mata_kuliah.store') }}" href="#"><i data-feather="plus" class="mr-2"></i>Tambah</a>
                    </div>
                    
                    <div class="card-body">
                        @if ($errors->any())
                        <div class="alert alert-danger alert-icon" role="alert">
                            <button class="close" type="button" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                            <div class="alert-icon-aside">
                                <i data-feather="feather"></i>
                            </div>
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
                        :route="route('admin.mata_kuliah.data_index')" 
                        :table="[
                            ['title' => 'No.', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => 'false', 'searchable' => 'false', 'width' => '10'],
                            ['title' => 'Kode', 'data' => 'kode_mata_kuliah', 'name' => 'kode_mata_kuliah', 'width' => '10'],
                            ['title' => 'Nama Mata Kuliah', 'data' => 'nama_mata_kuliah', 'name' => 'nama_mata_kuliah', 'classname' => 'text-left'],
                            ['title' => 'Program Studi', 'data' => 'prodi', 'name' => 'prodi', 'classname' => 'text-left'],
                            ['title' => 'Jenis', 'data' => 'jenis', 'name' => 'jenis'],
                            ['title' => 'Kelompok', 'data' => 'kelompok', 'name' => 'kelompok'],
                            ['title' => 'SKS Matkul', 'data' => 'sks_mata_kuliah', 'name' => 'sks_mata_kuliah'],
                            ['title' => 'SKS Tatap Muka', 'data' => 'sks_tatap_muka', 'name' => 'sks_tatap_muka'],
                            ['title' => 'SKS Praktek', 'data' => 'sks_praktek', 'name' => 'sks_praktek'],
                            ['title' => 'SKS Praktek Lapangan', 'data' => 'sks_praktek_lapangan', 'name' => 'sks_praktek_lapangan'],
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
    <x-slot name="title">Mata Kuliah</x-slot>
    <x-slot name="modalPosition">modal-dialog-centered</x-slot>
    
    @csrf 
    @method('post')
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="id_prodi">Program Studi</label>
            {!! Form::select('id_prodi', $prodi, null, ['class' => 'form-control '.($errors->has('id_prodi') ? 'is-invalid' : ''), 'id' => 'id_prodi']) !!}
            @error('id_prodi')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-6">
            <label for="kode_mata_kuliah">Kode Mata Kuliah</label>
            {!! Form::text('kode_mata_kuliah', null, ['class' => 'form-control '.($errors->has('kode_mata_kuliah') ? 'is-invalid' : ''), 'id' => 'kode_mata_kuliah']) !!}
            @error('kode_mata_kuliah')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group col-lg-6">
            <label for="nama_mata_kuliah">Nama Mata Kuliah</label>
            {!! Form::text('nama_mata_kuliah', null, ['class' => 'form-control '.($errors->has('nama_mata_kuliah') ? 'is-invalid' : ''), 'id' => 'nama_mata_kuliah']) !!}
            @error('nama_mata_kuliah')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-6">
            <label for="id_jenis_mata_kuliah">Jenis</label>
            {!! Form::select('id_jenis_mata_kuliah', $jenis_matkul, null, ['class' => 'form-control '.($errors->has('id_jenis_mata_kuliah') ? 'is-invalid' : ''), 'id' => 'id_jenis_mata_kuliah']) !!}
            @error('id_jenis_mata_kuliah')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group col-lg-6">
            <label for="id_kelompok_mata_kuliah">Kelompok</label>
            {!! Form::select('id_kelompok_mata_kuliah', $kelompok_matkul, null, ['class' => 'form-control '.($errors->has('id_kelompok_mata_kuliah') ? 'is-invalid' : ''), 'id' => 'id_kelompok_mata_kuliah']) !!}
            @error('id_kelompok_mata_kuliah')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-6">
            <label for="sks_mata_kuliah">SKS</label>
            {!! Form::number('sks_mata_kuliah', null, ['class' => 'form-control '.($errors->has('sks_mata_kuliah') ? 'is-invalid' : ''), 'id' => 'sks_mata_kuliah']) !!}
            @error('sks_mata_kuliah')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="form-group col-lg-6">
            <label for="sks_tatap_muka">SKS Tatap Muka</label>
            {!! Form::number('sks_tatap_muka', null, ['class' => 'form-control '.($errors->has('sks_tatap_muka') ? 'is-invalid' : ''), 'id' => 'sks_tatap_muka']) !!}
            @error('sks_tatap_muka')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-6">
            <label for="sks_mata_kuliah">SKS Praktek</label>
            {!! Form::number('sks_praktek', null, ['class' => 'form-control '.($errors->has('sks_praktek') ? 'is-invalid' : ''), 'id' => 'sks_praktek']) !!}
            @error('sks_praktek')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="form-group col-lg-6">
            <label for="sks_praktek_lapangan">SKS Praktek Lapangan</label>
            {!! Form::number('sks_praktek_lapangan', null, ['class' => 'form-control '.($errors->has('sks_praktek_lapangan') ? 'is-invalid' : ''), 'id' => 'sks_praktek_lapangan']) !!}
            @error('sks_praktek_lapangan')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-6">
            <label for="sks_simulasi">SKS Simulasi</label>
            {!! Form::number('sks_simulasi', null, ['class' => 'form-control '.($errors->has('sks_simulasi') ? 'is-invalid' : ''), 'id' => 'sks_simulasi']) !!}
            @error('sks_simulasi')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="form-group col-lg-6">
            <label for="metode_kuliah">Metode Kuliah</label>
            {!! Form::text('metode_kuliah', null, ['class' => 'form-control '.($errors->has('metode_kuliah') ? 'is-invalid' : ''), 'id' => 'metode_kuliah']) !!}
            @error('metode_kuliah')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <div class="form-group col-lg-6">
            <label for="tanggal_mulai_efektif">Tanggal Mulai Efektif</label>
            {!! Form::date('tanggal_mulai_efektif', null, ['class' => 'form-control '.($errors->has('tanggal_mulai_efektif') ? 'is-invalid' : ''), 'id' => 'tanggal_mulai_efektif']) !!}
            @error('tanggal_mulai_efektif')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="form-group col-lg-6">
            <label for="tanggal_selesai_efektif">Tanggal Selesai Efektif</label>
            {!! Form::date('tanggal_selesai_efektif', null, ['class' => 'form-control '.($errors->has('tanggal_selesai_efektif') ? 'is-invalid' : ''), 'id' => 'tanggal_selesai_efektif']) !!}
            @error('tanggal_selesai_efektif')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
    </div>

    @php
        $ya_tidak = [
            '1' => 'Ya',
            '0' => 'Tidak'
        ];
    @endphp
    <div class="form-group row">
        <div class="form-group col-lg-6">
            <label for="ada_sap">Ada SAP</label>
            {!! Form::select('ada_sap', $ya_tidak, null, ['class' => 'form-control '.($errors->has('nama_depan') ? 'is-invalid' : ''), 'id' => 'ada_sap']) !!}
        </div>
        <div class="form-group col-lg-6">
            <label for="ada_silabus">Ada Silabus</label>
            {!! Form::select('ada_silabus', $ya_tidak, null, ['class' => 'form-control '.($errors->has('nama_depan') ? 'is-invalid' : ''), 'id' => 'ada_silabus']) !!}
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-6">
            <label for="ada_bahan_ajar">Ada Bahan Ajar</label>
            {!! Form::select('ada_bahan_ajar', $ya_tidak, null, ['class' => 'form-control '.($errors->has('nama_depan') ? 'is-invalid' : ''), 'id' => 'ada_bahan_ajar']) !!}
        </div>
        <div class="form-group col-lg-6">
            <label for="ada_acara_praktek">Ada Acara Praktek</label>
            {!! Form::select('ada_acara_praktek', $ya_tidak, null, ['class' => 'form-control '.($errors->has('nama_depan') ? 'is-invalid' : ''), 'id' => 'ada_acara_praktek']) !!}
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-6">
            <label for="ada_diktat">Ada Diktat</label>
            {!! Form::select('ada_diktat', $ya_tidak, null, ['class' => 'form-control '.($errors->has('nama_depan') ? 'is-invalid' : ''), 'id' => 'ada_diktat']) !!}
        </div>
    </div>
    <x-slot name="footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </x-slot>
</x-modal>

<x-modal class="edit-form" id="modal-form">
    <x-slot name="title">Mata Kuliah</x-slot>
    <x-slot name="modalPosition">modal-dialog-centered</x-slot>
    @csrf
    @method('put')
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="kode_mata_kuliah">Kode Mata Kuliah</label>
            {!! Form::text('kode_mata_kuliah', null, ['class' => 'form-control', 'id' => 'kode_mata_kuliah']) !!}
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="nama_mata_kuliah">Nama Mata Kuliah</label>
            {!! Form::text('nama_mata_kuliah', null, ['class' => 'form-control', 'id' => 'nama_mata_kuliah']) !!}
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="metode_kuliah">Metode Kuliah</label>
            {!! Form::text('metode_kuliah', null, ['class' => 'form-control', 'id' => 'metode_kuliah']) !!}
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="id_jenis_mata_kuliah">Jenis</label>
            {!! Form::select('id_jenis_mata_kuliah', $jenis_matkul, null, ['class' => 'form-control', 'id' => 'id_jenis_mata_kuliah']) !!}
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="id_kelompok_mata_kuliah">Kelompok</label>
            {!! Form::select('id_kelompok_mata_kuliah', $kelompok_matkul, null, ['class' => 'form-control', 'id' => 'id_kelompok_mata_kuliah']) !!}
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="sks_mata_kuliah">SKS</label>
            {!! Form::number('sks_mata_kuliah', null, ['class' => 'form-control', 'id' => 'sks_mata_kuliah']) !!}
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="sks_tatap_muka">SKS Tatap Muka</label>
            {!! Form::number('sks_tatap_muka', null, ['class' => 'form-control', 'id' => 'sks_tatap_muka']) !!}
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="sks_mata_kuliah">SKS Praktek</label>
            {!! Form::number('sks_praktek', null, ['class' => 'form-control', 'id' => 'sks_praktek']) !!}
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="sks_praktek_lapangan">SKS Praktek Lapangan</label>
            {!! Form::number('sks_praktek_lapangan', null, ['class' => 'form-control', 'id' => 'sks_praktek_lapangan']) !!}
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="sks_simulasi">SKS Simulasi</label>
            {!! Form::number('sks_simulasi', null, ['class' => 'form-control', 'id' => 'sks_simulasi']) !!}
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="tanggal_mulai_efektif">Tanggal Mulai Efektif</label>
            {!! Form::date('tanggal_mulai_efektif', null, ['class' => 'form-control', 'id' => 'tanggal_mulai_efektif']) !!}
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="tanggal_selesai_efektif">Tanggal Selesai Efektif</label>
            {!! Form::date('tanggal_selesai_efektif', null, ['class' => 'form-control', 'id' => 'tanggal_selesai_efektif']) !!}
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
            var nama_kurikulum = $(this).data('nama');
            var id_semester = $(this).data('semester');
            var jumlah_sks_lulus = $(this).data('sks_lulus');
            var jumlah_sks_wajib = $(this).data('sks_wajib');
            var jumlah_sks_pilihan = $(this).data('sks_pilihan');

            $('[name=id_semester]').val(id_semester);
            $('[name=nama_kurikulum]').val(nama_kurikulum);
            $('[name=id_prodi]').val(id_prodi);
            $('[name=jumlah_sks_lulus]').val(jumlah_sks_lulus);
            $('[name=jumlah_sks_wajib]').val(jumlah_sks_wajib);
            $('[name=jumlah_sks_pilihan]').val(jumlah_sks_pilihan);

        });
    </script>
@endpush