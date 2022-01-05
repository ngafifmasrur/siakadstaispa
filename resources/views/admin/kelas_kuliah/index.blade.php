@extends('layouts.app')
@section('title', 'Kelas Kuliah')

@section('content')

<x-header>
    Kelas Kuliah
</x-header>
<!-- Main page content-->
<div class="container mt-n10">
    <div class="row">
        <div class="col-lg-12">
            <form action="" method="post">
                <div class="card">
                    <div class="card-header">
                        Data Kelas Kuliah
                        <a class="float-right btn btn-sm btn-outline-blue add-form" data-url="{{ route('admin.kelas_kuliah.store') }}" href="#"><i data-feather="plus" class="mr-2"></i>Tambah</a>
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
                        :route="route('admin.kelas_kuliah.data_index')" 
                        :table="[
                            ['title' => 'No.', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => 'false', 'searchable' => 'false', 'width' => '10'],                            
                            ['title' => 'Nama Kelas', 'data' => 'nama_kelas_kuliah', 'name' => 'nama_kelas_kuliah', 'classname' => 'text-left'],
                            ['title' => 'Program Studi', 'data' => 'prodi', 'name' => 'prodi', 'classname' => 'text-left'],
                            ['title' => 'Semester', 'data' => 'semester', 'name' => 'semester'],
                            ['title' => 'Matkul', 'data' => 'matkul', 'name' => 'matkul'],
                            ['title' => 'Bahasan', 'data' => 'bahasan', 'name' => 'bahasan', 'classname' => 'text-left'],
                            ['title' => 'Tanggal Mulai Efektif', 'data' => 'tanggal_mulai_efektif', 'name' => 'tanggal_mulai_efektif'],
                            ['title' => 'Tanggal Akhir Efektif', 'data' => 'tanggal_akhir_efektif', 'name' => 'tanggal_akhir_efektif'],
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
    <x-slot name="title">Kelas Kuliah</x-slot>
    <x-slot name="modalPosition">modal-dialog-centered</x-slot>
    
    @csrf 
    @method('post')
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
            <label for="id_semester">Semester</label>
            {!! Form::select('id_semester', $semester, null, ['class' => 'form-control '.($errors->has('id_semester') ? 'is-invalid' : ''), 'id' => 'id_semester']) !!}
            @error('id_semester')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-6">
            <label for="id_matkul">Mata Kuliah</label>
            {!! Form::select('id_matkul', $mata_kuliah, null, ['class' => 'form-control '.($errors->has('nilai_huruf') ? 'is-invalid' : ''), 'id' => 'id_matkul']) !!}
            @error('id_matkul')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group col-lg-6">
            <label for="nama_kelas_kuliah">Nama Kelas</label>
            {!! Form::text('nama_kelas_kuliah', null, ['class' => 'form-control '.($errors->has('nama_kelas_kuliah') ? 'is-invalid' : ''), 'id' => 'nama_kelas_kuliah']) !!}
            @error('nama_kelas_kuliah')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="bahasan">Bahasan</label>
            {!! Form::text('bahasan', null, ['class' => 'form-control '.($errors->has('bahasan') ? 'is-invalid' : ''), 'id' => 'bahasan']) !!}
            @error('bahasan')
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
            <label for="tanggal_akhir_efektif">Tanggal Akhir Efektif</label>
            {!! Form::date('tanggal_akhir_efektif', null, ['class' => 'form-control '.($errors->has('tanggal_selesai_efektif') ? 'is-invalid' : ''), 'id' => 'tanggal_akhir_efektif']) !!}
            @error('tanggal_akhir_efektif')
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
    <x-slot name="title">Kelas Kuliah</x-slot>
    <x-slot name="modalPosition">modal-dialog-centered</x-slot>
    @csrf
    @method('put')
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
            <label for="id_semester">Semester</label>
            {!! Form::select('id_semester', $semester, null, ['class' => 'form-control '.($errors->has('id_semester') ? 'is-invalid' : ''), 'id' => 'id_semester']) !!}
            @error('id_semester')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-6">
            <label for="id_matkul">Mata Kuliah</label>
            {!! Form::select('id_matkul', $mata_kuliah, null, ['class' => 'form-control '.($errors->has('nilai_huruf') ? 'is-invalid' : ''), 'id' => 'nilai_huruf']) !!}
            @error('id_matkul')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group col-lg-6">
            <label for="nama_kelas_kuliah">Nama Kelas</label>
            {!! Form::text('nama_kelas_kuliah', null, ['class' => 'form-control '.($errors->has('nama_kelas_kuliah') ? 'is-invalid' : ''), 'id' => 'nama_kelas_kuliah']) !!}
            @error('nama_kelas_kuliah')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="bahasan">Bahasan</label>
            {!! Form::text('bahasan', null, ['class' => 'form-control '.($errors->has('bahasan') ? 'is-invalid' : ''), 'id' => 'bahasan']) !!}
            @error('bahasan')
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
            <label for="tanggal_akhir_efektif">Tanggal Akhir Efektif</label>
            {!! Form::date('tanggal_akhir_efektif', null, ['class' => 'form-control '.($errors->has('tanggal_selesai_efektif') ? 'is-invalid' : ''), 'id' => 'tanggal_akhir_efektif']) !!}
            @error('tanggal_akhir_efektif')
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
            var id_matkul = $(this).data('matkul');
            var id_semester = $(this).data('semester');
            var nama_kelas_kuliah = $(this).data('nama');
            var bahasan = $(this).data('bahasan');
            var tanggal_mulai = $(this).data('tanggal_mulai');
            var tanggal_akhir = $(this).data('tanggal_akhir');

            $('[name=id_prodi]').val(id_prodi);
            $('[name=id_matkul]').val(id_matkul);
            $('[name=id_semester]').val(id_semester);
            $('[name=nama_kelas_kuliah]').val(nama_kelas_kuliah);
            $('[name=bahasan]').val(bahasan);
            $('[name=tanggal_mulai_efektif]').val(tanggal_mulai);
            $('[name=tanggal_akhir_efektif]').val(tanggal_akhir);

        });
    </script>
@endpush