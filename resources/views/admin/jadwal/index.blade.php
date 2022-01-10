@extends('layouts.app')
@section('title', 'Jadwal')

@section('content')
<header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
    <div class="container">
        <div class="page-header-content pt-4">
            <div class="row align-items-center justify-content-between">
                <div class="col-auto mt-4">
                    <h1 class="page-header-title">
                        <div class="page-header-icon"><i data-feather="grid"></i></div>
                        Jadwal
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
                        Data Jadwal
                        <a class="float-right btn btn-sm btn-outline-blue add-form" data-url="{{ route('admin.jadwal.store') }}" href="#"><i data-feather="plus" class="mr-2"></i>Tambah</a>
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
                        :route="route('admin.jadwal.data_index')" 
                        :table="[
                            ['title' => 'No.', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => 'false', 'searchable' => 'false', 'width' => '10'],
                            ['title' => 'Ruangan', 'data' => 'ruangan', 'name' => 'ruangan', 'classname' => 'text-left'],
                            ['title' => 'Dosen', 'data' => 'dosen', 'name' => 'dosen', 'classname' => 'text-left'],
                            ['title' => 'Program Studi', 'data' => 'prodi', 'name' => 'prodi', 'classname' => 'text-left'],
                            ['title' => 'Kelas', 'data' => 'kelas', 'name' => 'kelas', 'classname' => 'text-left'],
                            ['title' => 'Hari', 'data' => 'hari', 'name' => 'hari', 'classname' => 'text-left'],
                            ['title' => 'Jam Mulai', 'data' => 'jam_mulai', 'name' => 'jam_mulai'],
                            ['title' => 'Jam Akhir', 'data' => 'jam_akhir', 'name' => 'jam_akhir'],
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
    <x-slot name="title">Jadwal</x-slot>
    <x-slot name="modalPosition">modal-dialog-centered</x-slot>
    
    @csrf 
    @method('post')
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="id_dosen">Dosen</label>
            {!! Form::select('id_dosen', $dosen, null, ['class' => 'form-control '.($errors->has('id_dosen') ? 'is-invalid' : ''), 'id' => 'id_dosen']) !!}
            @error('id_dosen')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
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
        <div class="form-group col-lg-12">
            <label for="id_kelas">Kelas</label>
            {!! Form::select('id_kelas', $kelas, null, ['class' => 'form-control '.($errors->has('id_kelas') ? 'is-invalid' : ''), 'id' => 'id_kelas']) !!}
            @error('id_kelas')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="id_matkul_aktif">Mata Kuliah</label>
            {!! Form::select('id_matkul_aktif', $matkul, null, ['class' => 'form-control '.($errors->has('id_matkul_aktif') ? 'is-invalid' : ''), 'id' => 'id_matkul_aktif']) !!}
            @error('id_matkul_aktif')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="id_ruang">Ruangan</label>
            {!! Form::select('id_ruang', $ruangan, null, ['class' => 'form-control '.($errors->has('id_ruang') ? 'is-invalid' : ''), 'id' => 'id_ruang']) !!}
            @error('id_ruang')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    @php
        $hari = [
            'Senin' => 'Senin',
            'Selasa' => 'Selasa',
            'Rabu' => 'Rabu',
            'Kamis' => 'Kamis',
            'Jumat' => 'Jumat',
            'Sabtu' => 'Sabtu',
            'Minggu' => 'Minggu',
        ];
    @endphp
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="hari">Hari</label>
            {!! Form::select('hari', $hari, null, ['class' => 'form-control '.($errors->has('hari') ? 'is-invalid' : ''), 'id' => 'hari']) !!}
            @error('hari')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="jam_mulai">Jam Mulai</label>
            {!! Form::time('jam_mulai',null, ['class' => 'form-control '.($errors->has('jam_mulai') ? 'is-invalid' : ''), 'id' => 'jam_mulai']) !!}
            @error('jam_mulai')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="jam_akhir">Jam Akhir</label>
            {!! Form::time('jam_akhir',null, ['class' => 'form-control '.($errors->has('jam_akhir') ? 'is-invalid' : ''), 'id' => 'jam_akhir']) !!}
            @error('jam_akhir')
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
    <x-slot name="title">Jadwal</x-slot>
    <x-slot name="modalPosition">modal-dialog-centered</x-slot>
    @csrf
    @method('put')
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="id_dosen">Dosen</label>
            {!! Form::select('id_dosen', $dosen, null, ['class' => 'form-control '.($errors->has('id_dosen') ? 'is-invalid' : ''), 'id' => 'id_dosen']) !!}
            @error('id_dosen')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
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
        <div class="form-group col-lg-12">
            <label for="id_kelas">Kelas</label>
            {!! Form::select('id_kelas', $kelas, null, ['class' => 'form-control '.($errors->has('id_kelas') ? 'is-invalid' : ''), 'id' => 'id_kelas']) !!}
            @error('id_kelas')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="id_matkul_aktif">Mata Kuliah</label>
            {!! Form::select('id_matkul_aktif', $matkul, null, ['class' => 'form-control '.($errors->has('id_matkul_aktif') ? 'is-invalid' : ''), 'id' => 'id_matkul_aktif']) !!}
            @error('id_matkul_aktif')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="id_ruang">Ruangan</label>
            {!! Form::select('id_ruang', $ruangan, null, ['class' => 'form-control '.($errors->has('id_ruang') ? 'is-invalid' : ''), 'id' => 'id_ruang']) !!}
            @error('id_ruang')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="hari">Hari</label>
            {!! Form::select('hari', $hari, null, ['class' => 'form-control '.($errors->has('hari') ? 'is-invalid' : ''), 'id' => 'hari']) !!}
            @error('hari')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="jam_mulai">Jam Mulai</label>
            {!! Form::time('jam_mulai',null, ['class' => 'form-control '.($errors->has('jam_mulai') ? 'is-invalid' : ''), 'id' => 'jam_mulai']) !!}
            @error('jam_mulai')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="jam_akhir">Jam Akhir</label>
            {!! Form::time('jam_akhir',null, ['class' => 'form-control '.($errors->has('jam_akhir') ? 'is-invalid' : ''), 'id' => 'jam_akhir']) !!}
            @error('jam_akhir')
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
            var id_prodi = $(this).data('id_prodi');
            var id_dosen = $(this).data('id_dosen');
            var id_kelas = $(this).data('id_kelas');
            var id_matkul_aktif = $(this).data('id_matkul_aktif');
            var id_ruang = $(this).data('id_ruang');
            var hari = $(this).data('hari');
            var jam_mulai = $(this).data('jam_mulai');
            var jam_akhir = $(this).data('jam_akhir');

            $('[name=id_prodi]').val(id_prodi);
            $('[name=id_dosen]').val(id_dosen);
            $('[name=id_kelas]').val(id_kelas);
            $('[name=id_matkul_aktif]').val(id_matkul_aktif);
            $('[name=id_ruang]').val(id_ruang);
            $('[name=hari]').val(hari);
            $('[name=jam_mulai]').val(jam_mulai);
            $('[name=jam_akhir]').val(jam_akhir);

        });
    </script>
@endpush