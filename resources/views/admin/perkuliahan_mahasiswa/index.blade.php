@extends('layouts.app')
@section('title', 'Perkuliahan Mahasiswa')

@section('content')

<x-header>
    Perkuliahan Mahasiswa
</x-header>

<x-card>
    <div class="row">
        <div class="form-group col-lg-3">
            <label for="prodi">Program Studi</label>
            {!! Form::select('prodi', $prodi, null, ['class' => 'form-control', 'id' => 'prodi']) !!}
        </div>
        <div class="form-group col-lg-3">
            <label for="semester">Semester</label>
            {!! Form::select('semester', $semester, $semester_id, ['class' => 'form-control', 'id' => 'semester']) !!}
        </div>
        <div class="form-group col-lg-3">
            <label for="angkatan">Angkatan</label>
            {!! Form::select('angkatan', $angkatan, null, ['class' => 'form-control', 'id' => 'angkatan']) !!}
        </div>
        <div class="form-group col-lg-3">
            <label for="status_mahasiswa">Status Mahasiswa</label>
            {!! Form::select('status_mahasiswa', $status_mahasiswa, null, ['class' => 'form-control', 'id' => 'status_mahasiswa']) !!}
        </div>
    </div>
</x-card>

<x-card-table>
    <x-slot name="title">Data Perkuliahan Mahasiswa</x-slot>
    <x-slot name="button">
        <a class="btn btn-app btn-sm btn-primary add-form" data-url="{{ route('admin.perkuliahan_mahasiswa.store') }}" href="#"><i class="fa fa-plus mr-2"></i>Tambah</a>
    </x-slot>

    <x-datatable 
    :route="route('admin.perkuliahan_mahasiswa.data_index')" 
    :table="[
        ['title' => 'No.', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => 'false', 'searchable' => 'false', 'width' => '10'],                            
        ['title' => 'Nama Mahasiswa', 'data' => 'nama_mahasiswa', 'name' => 'nama_mahasiswa', 'classname' => 'text-left'],
        ['title' => 'NIM', 'data' => 'nim', 'name' => 'nim', 'classname' => 'text-center'],
        ['title' => 'Program Studi', 'data' => 'nama_program_studi', 'name' => 'nama_program_studi', 'classname' => 'text-left'],
        ['title' => 'Semester', 'data' => 'nama_semester', 'name' => 'nama_semester', 'classname' => 'text-left'],
        ['title' => 'IPS', 'data' => 'ips', 'name' => 'ips'],
        ['title' => 'IPK', 'data' => 'ipk', 'name' => 'ipk'],
        ['title' => 'SKS Semester', 'data' => 'sks_semester', 'name' => 'sks_semester'],
        ['title' => 'SKS Total', 'data' => 'sks_total', 'name' => 'sks_total'],
        ['title' => 'Aksi', 'data' => 'action', 'orderable' => 'false', 'searchable' => 'false'],
    ]"
    :filter="[
        ['data' => 'prodi', 'value' => '$(`#prodi`).val()'],
        ['data' => 'semester', 'value' => '$(`#semester`).val()'],
        ['data' => 'angkatan', 'value' => '$(`#angkatan`).val()'],
        ['data' => 'status_mahasiswa', 'value' => '$(`#status_mahasiswa`).val()']
    ]"
    />

</x-card-table>

<x-modal.delete/>

<x-modal class="modal-form" id="modal-form">
    <x-slot name="title">Perkuliahan Mahasiswa</x-slot>
    <x-slot name="modalPosition">modal-dialog-centered</x-slot>
    
    @csrf @method('post')
    <div class="row">
        <div class="form-group col-lg-12">
            <label for="id_registrasi_mahasiswa">Mahasiswa</label>
            {!! Form::select('id_registrasi_mahasiswa', $mahasiswa, null, ['class' => 'form-control '.($errors->has('id_registrasi_mahasiswa') ? 'is-invalid' : ''), 'id' => 'id_registrasi_mahasiswa']) !!}
            @error('id_registrasi_mahasiswa')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="row">
        <div class="form-group col-lg-12">
            <label for="id_semester">Semester</label>
            {!! Form::select('id_semester', $semester, null, ['class' => 'form-control '.($errors->has('id_semester') ? 'is-invalid' : ''), 'id' => 'id_semester']) !!}
            @error('id_semester')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="row">
        <div class="form-group col-lg-12">
            <label for="id_status_mahasiswa">Status Mahasiswa</label>
            {!! Form::select('id_status_mahasiswa', $status_mahasiswa, null, ['class' => 'form-control '.($errors->has('id_status_mahasiswa') ? 'is-invalid' : ''), 'id' => 'id_status_mahasiswa']) !!}
            @error('id_status_mahasiswa')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="row">
        <div class="form-group col-lg-12">
            <label for="ips">IPS</label>
            {!! Form::number('ips', null, ['class' => 'form-control '.($errors->has('ips') ? 'is-invalid' : ''), 'id' => 'ips']) !!}
            @error('ips')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="row">
        <div class="form-group col-lg-12">
            <label for="ipk">IPK</label>
            {!! Form::number('ipk', null, ['class' => 'form-control '.($errors->has('ipk') ? 'is-invalid' : ''), 'id' => 'ipk']) !!}
            @error('ipk')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="row">
        <div class="form-group col-lg-12">
            <label for="sks_semester">SKS Semester</label>
            {!! Form::number('sks_semester', null, ['class' => 'form-control '.($errors->has('sks_semester') ? 'is-invalid' : ''), 'id' => 'sks_semester']) !!}
            @error('sks_semester')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="row">
        <div class="form-group col-lg-12">
            <label for="total_sks">Total SKS</label>
            {!! Form::number('total_sks', null, ['class' => 'form-control '.($errors->has('total_sks') ? 'is-invalid' : ''), 'id' => 'total_sks']) !!}
            @error('total_sks')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="row">
        <div class="form-group col-lg-12">
            <label for="biaya_kuliah_smt">Biaya Kuliah Semester</label>
            {!! Form::number('biaya_kuliah_smt', null, ['class' => 'form-control '.($errors->has('biaya_kuliah_smt') ? 'is-invalid' : ''), 'id' => 'biaya_kuliah_smt']) !!}
            @error('biaya_kuliah_smt')
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
            $(document).on('change','#prodi, #semester, #angkatan, #status_mahasiswa',function(){
                table.ajax.reload();
            });
        });

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
            var id_registrasi_mahasiswa = $(this).data('nim');
            var id_semester = $(this).data('id_jenis_daftar');
            var id_status_mahasiswa = $(this).data('id_jalur_daftar');
            var ips = $(this).data('nama');
            var ipk = $(this).data('id_perguruan_tinggi');
            var sks_semester = $(this).data('id_prodi');
            var total_sks = $(this).data('id_perguruan_tinggi_asal');
            var biaya_kuliah_smt = $(this).data('id_prodi_asal');

            $('[name=nim]').val(nim);
            $('[name=id_periode]').val(id_periode);
            $('[name=id_jenis_daftar]').val(id_jenis_daftar);
            $('[name=id_periode_masuk]').val(id_periode_masuk);
            $('[name=id_perguruan_tinggi]').val(id_perguruan_tinggi);
            $('[name=id_perguruan_tinggi_asal]').val(id_perguruan_tinggi_asal);
            $('[name=id_prodi_asal]').val(id_prodi_asal);
            $('[name=id_pembiayaan]').val(id_pembiayaan);
            $('[name=sks_diakui]').val(sks_diakui);
        });
    </script>
@endpush