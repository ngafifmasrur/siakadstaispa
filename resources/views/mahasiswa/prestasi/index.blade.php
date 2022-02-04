@extends('layouts.app')
@section('title', 'Registrasi Mahasiswa')

@section('content')

<x-header>
    Registrasi Mahasiswa
</x-header>

<x-card-table>
    <x-slot name="title">Data Registrasi Mahasiswa</x-slot>
    <x-slot name="button">
        <a class="float-right btn btn-sm btn-outline-blue add-form" data-url="#" href="#"><i data-feather="plus" class="mr-2"></i>Tambah</a>
    </x-slot>

    <x-datatable 
    :route="route('admin.registrasi_mahasiswa.data_index')" 
    :table="[
        ['title' => 'No.', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => 'false', 'searchable' => 'false', 'width' => '10'],                            
        ['title' => 'NIM', 'data' => 'nim', 'name' => 'nim'],
        ['title' => 'Nama Mahasiswa', 'data' => 'nama_mahasiswa', 'name' => 'nama_mahasiswa', 'classname' => 'text-left'],
        ['title' => 'Periode Masuk', 'data' => 'periode', 'name' => 'periode'],
        ['title' => 'Program Studi', 'data' => 'prodi', 'name' => 'prodi', 'classname' => 'text-left'],
        ['title' => 'Aksi', 'data' => 'action', 'orderable' => 'false', 'searchable' => 'false'],
    ]"
    />

</x-card-table>

<x-modal.delete/>

<x-modal class="modal-form" id="modal-form">
    <x-slot name="title">Ruang Kelas</x-slot>
    <x-slot name="modalPosition">modal-dialog-centered</x-slot>
    
    @csrf 
    @method('post')
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="id_mahasiswa">Mahasiswa</label>
            {!! Form::text('id_mahasiswa', null, ['class' => 'form-control '.($errors->has('id_mahasiswa') ? 'is-invalid' : ''), 'id' => 'id_mahasiswa']) !!}
            @error('id_mahasiswa')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="id_jenis_daftar">Jenis Daftar</label>
            {!! Form::text('id_jenis_daftar', null, ['class' => 'form-control '.($errors->has('id_jenis_daftar') ? 'is-invalid' : ''), 'id' => 'id_jenis_daftar']) !!}
            @error('id_jenis_daftar')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="id_jalur_daftar">Jalur Masuk</label>
            {!! Form::text('id_jalur_daftar', null, ['class' => 'form-control '.($errors->has('id_jalur_daftar') ? 'is-invalid' : ''), 'id' => 'id_jalur_daftar']) !!}
            @error('id_jalur_daftar')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="id_periode_masuk">Periode Masuk</label>
            {!! Form::text('id_periode_masuk', null, ['class' => 'form-control '.($errors->has('id_periode_masuk') ? 'is-invalid' : ''), 'id' => 'id_periode_masuk']) !!}
            @error('id_periode_masuk')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="tanggal_daftar">Tanggal Masuk</label>
            {!! Form::date('tanggal_daftar', null, ['class' => 'form-control '.($errors->has('tanggal_daftar') ? 'is-invalid' : ''), 'id' => 'tanggal_daftar']) !!}
            @error('tanggal_daftar')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="tanggal_daftar">Tanggal Masuk</label>
            {!! Form::date('tanggal_daftar', null, ['class' => 'form-control '.($errors->has('tanggal_daftar') ? 'is-invalid' : ''), 'id' => 'tanggal_daftar']) !!}
            @error('tanggal_daftar')
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

        function editForm(url, title = 'Edit', modal = '#modal-form', func) {
                $.get(url)
                    .done(response => {
                        $(`${modal}`).modal('show');
                        $(`${modal} .modal-title`).text(title);
                        $(`${modal} form`).attr('action', url);
                        $(`${modal} [name=_method]`).val('put');

                        resetForm(`${modal} form`);
                        loopForm(response.data);

                        if (func != undefined) {
                            func(response.data);
                        }
                    })
                    .fail(errors => {
                        alert('Tidak dapat menampilkan data');
                        return;
                    });
            }

    </script>
@endpush