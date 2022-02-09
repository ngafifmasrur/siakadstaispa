@extends('layouts.app')
@section('title', 'Registrasi Mahasiswa')

@section('content')

<x-header>
    Registrasi Mahasiswa
</x-header>

<x-card>
    <div class="row">
        <div class="form-group col-lg-3">
            <label for="prodi">Program Studi</label>
            {!! Form::select('prodi', $prodi, null, ['class' => 'form-control', 'id' => 'prodi']) !!}
        </div>
        <div class="form-group col-lg-3">
            <label for="periode">Periode Masuk</label>
            {!! Form::select('periode', $periode, $semester_id, ['class' => 'form-control', 'id' => 'periode']) !!}
        </div>
    </div>
</x-card>

<x-card-table>
    <x-slot name="title">Data Registrasi Mahasiswa</x-slot>
    <x-slot name="button">
        <a class="btn btn-app btn-sm btn-primary add-form" data-url="{{ route('admin.registrasi_mahasiswa.store') }}" href="#"><i class="fa fa-plus mr-2"></i>Tambah</a>
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
    :filter="[
        ['data' => 'id_prodi', 'value' => '$(`#prodi`).val()'],
        ['data' => 'id_periode_masuk', 'value' => '$(`#periode`).val()']
    ]"
    />

</x-card-table>

<x-modal.delete/>

<x-modal class="modal-form" id="modal-form">
    <x-slot name="title">Registrasi Mahasiswa</x-slot>
    <x-slot name="modalPosition">modal-dialog-centered</x-slot>
    
    @csrf 
    @method('post')
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="id_mahasiswa">Mahasiswa</label>
            {!! Form::select('id_mahasiswa', $mahasiswa, null, ['class' => 'form-control '.($errors->has('id_mahasiswa') ? 'is-invalid' : ''), 'id' => 'id_mahasiswa']) !!}
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
            {!! Form::select('id_jenis_daftar', $jenis_daftar, null, ['class' => 'form-control '.($errors->has('id_jenis_daftar') ? 'is-invalid' : ''), 'id' => 'id_jenis_daftar']) !!}
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
            {!! Form::select('id_jalur_daftar', $jalur_masuk, null, ['class' => 'form-control '.($errors->has('id_jalur_daftar') ? 'is-invalid' : ''), 'id' => 'id_jalur_daftar']) !!}
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
            {!! Form::select('id_periode_masuk', $periode, null, ['class' => 'form-control '.($errors->has('id_periode_masuk') ? 'is-invalid' : ''), 'id' => 'id_periode_masuk']) !!}
            @error('id_periode_masuk')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="tanggal_daftar">Tanggal Daftar</label>
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
            <label for="sks_diakui">SKS Diakui</label>
            {!! Form::number('sks_diakui', null, ['class' => 'form-control '.($errors->has('sks_diakui') ? 'is-invalid' : ''), 'id' => 'sks_diakui']) !!}
            @error('sks_diakui')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="id_pembiayaan">Pembiayaan</label>
            {!! Form::select('id_pembiayaan', $pembiayaan, null, ['class' => 'form-control '.($errors->has('id_pembiayaan') ? 'is-invalid' : ''), 'id' => 'id_pembiayaan']) !!}
            @error('id_pembiayaan')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="biaya_masuk">Biaya Masuk</label>
            {!! Form::number('biaya_masuk', null, ['class' => 'form-control '.($errors->has('biaya_masuk') ? 'is-invalid' : ''), 'id' => 'biaya_masuk']) !!}
            @error('biaya_masuk')
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
        $( document ).ready(function() {
            $(document).on('change','#prodi, #periode',function(){
                table.ajax.reload();
            });
        });
    
        $('.add-form').on('click', function () {
            $('.modal-form').modal('show');
            $('.modal-form form')[0].reset();
            $('[name=_method]').val('post');
            $('.modal-form form').attr('action', $(this).data('url'));
        });
    </script>
@endpush