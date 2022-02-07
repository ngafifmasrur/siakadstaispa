@extends('layouts.app')
@section('title', 'Anggota Kegiatan Mahasiswa')

@section('content')

<x-header>
    Anggota Kegiatan Mahasiswa
</x-header>

<x-card-table>
    <x-slot name="title">Data Anggota Kegiatan Mahasiswa</x-slot>
    <x-slot name="button">
        <a class="float-right btn btn-sm btn-outline-primary add-form" data-url="#" href="#"><i data-feather="plus" class="mr-2"></i>Tambah</a>
    </x-slot>

    <x-datatable 
    :route="route('admin.anggota_aktivitas.data_index', $aktivitas)" 
    :table="[
        ['title' => 'No.', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => 'false', 'searchable' => 'false', 'width' => '10'],                            
        ['title' => 'Judul', 'data' => 'judul', 'name' => 'judul'],
        ['title' => 'NIM', 'data' => 'nim', 'name' => 'nim'],
        ['title' => 'Mahasiswa', 'data' => 'mahasiswa', 'name' => 'mahasiswa', 'classname' => 'text-left'],
        ['title' => 'Peran', 'data' => 'jenis_peran', 'name' => 'jenis_peran', 'classname' => 'text-left']
    ]"
    />

</x-card-table>

<x-modal.delete/>

<x-modal class="modal-form" id="modal-form">
    <x-slot name="title">Anggota Kegiatan</x-slot>
    <x-slot name="modalPosition">modal-dialog-centered</x-slot>
    
    @csrf 
    @method('post')

    <input type="hidden" name="id_aktivitas" value="{{ $aktivitas }}">

    <div class="row">
        <div class="form-group col-lg-6">
            <label for="id_registrasi_mahasiswa">Mahasiswa</label>
            {!! Form::select('id_registrasi_mahasiswa', $mahasiswa, null, ['class' => 'form-control '.($errors->has('id_registrasi_mahasiswa') ? 'is-invalid' : ''), 'id' => 'id_registrasi_mahasiswa']) !!}
            @error('id_registrasi_mahasiswa')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="form-group col-lg-6">
            <label for="jenis_peran">Jenis Peran</label>
            {!! Form::select('jenis_peran', $jenisPeran, null, ['class' => 'form-control '.($errors->has('jenis_peran') ? 'is-invalid' : ''), 'id' => 'jenis_peran']) !!}
            @error('jenis_peran')
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

            $('[name=id_aktivitas]').val('{{ $aktivitas }}');
        });

        $(document).on('click', '.btn_edit', function () {
            $('.modal-form').modal('show');
            $('.modal-form form')[0].reset();
            $('.modal-form form').attr('action',  $(this).data('route'));
            $('[name=_method]').val('put');

            $('[name=id_aktivitas]').val('{{ $aktivitas }}');
            
            var id_registrasi_mahasiswa = $(this).data('id_registrasi_mahasiswa');
            var jenis_peran = $(this).data('jenis_peran');

            $('[name=id_registrasi_mahasiswa]').val(id_registrasi_mahasiswa);
            $('[name=jenis_peran]').val(jenis_peran);
        });
    </script>
@endpush