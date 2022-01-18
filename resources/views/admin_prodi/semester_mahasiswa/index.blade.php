@extends('layouts.app')
@section('title', 'Semester Mahasiswa')

@section('content')

<x-header>
    Semester Mahasiswa
</x-header>

<x-card>
    <div class="row">
        <div class="form-group col-lg-3">
            <label for="tahun_ajaran">Tahun Ajaran</label>
            {!! Form::select('tahun_ajaran', $tahun_ajaran, null, ['class' => 'form-control', 'id' => 'tahun_ajaran']) !!}
        </div>
        <div class="form-group col-lg-3">
            <label for="semester">Semester</label>
            {!! Form::select('semester', $semester, null, ['class' => 'form-control', 'id' => 'semester']) !!}
        </div>
    </div>
</x-card>

<x-card-table>
    <x-slot name="title">Data Semester Mahasiswa</x-slot>
    <x-slot name="button">
        <a class="btn btn-app btn-sm btn-primary add-form" data-url="{{ route('admin_prodi.semester_mahasiswa.store') }}" href="#"><i class="fa fa-plus mr-2"></i>Tambah</a>
        <button type="button" class="btn btn-app btn-sm btn-success btn-generate" data-route="{{ route('admin_prodi.semester_mahasiswa.generate') }}" disabled><i class="fa fa-plus mr-2"></i>Generate</button>

    </x-slot>

    <x-datatable 
    :route="route('admin_prodi.semester_mahasiswa.data_index')" 
    :table="[
        ['title' => 'No.', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => 'false', 'searchable' => 'false', 'width' => '10'],  
        ['title' => 'Nama Mahasiswa', 'data' => 'mahasiswa', 'name' => 'mahasiswa', 'classname' => 'text-left'], 
        ['title' => 'Tahun Ajaran', 'data' => 'tahun_ajaran', 'name' => 'tahun_ajaran'],                         
        ['title' => 'Semester', 'data' => 'semester', 'name' => 'semester'],              
        ['title' => 'Program Studi', 'data' => 'prodi', 'name' => 'prodi', 'classname' => 'text-left'],                         
        ['title' => 'Status', 'data' => 'status', 'name' => 'status'],
        ['title' => 'Aksi', 'data' => 'action', 'orderable' => 'false', 'searchable' => 'false'],
    ]"
    :filter="[
        ['data' => 'prodi', 'value' => '$(`#prodi`).val()'],
        ['data' => 'semester', 'value' => '$(`#semester`).val()'],
        ['data' => 'tahun_ajaran', 'value' => '$(`#tahun_ajaran`).val()']
    ]"
    />

</x-card-table>

<x-modal.delete/>

<x-modal class="modal-form" id="modal-form">
    <x-slot name="title">Semester Mahasiswa</x-slot>
    <x-slot name="modalPosition">modal-dialog-centered</x-slot>
    
    @csrf 
    @method('post')
    <div class="row">
        <div class="form-group col-lg-12">
            <label for="id_mahasiswa">Mahasiswa</label>
            {!! Form::select('id_mahasiswa', $mahasiswa, NULL, ['class' => 'form-control '.($errors->has('id_mahasiswa') ? 'is-invalid' : ''), 'id' => 'id_mahasiswa']) !!}
            @error('id_mahasiswa')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>  
    <div class="row">
        <div class="form-group col-lg-6">
            <label for="id_tahun_ajaran">Tahun Ajaran</label>
            {!! Form::select('id_tahun_ajaran', $tahun_ajaran, NULL, ['class' => 'form-control '.($errors->has('id_tahun_ajaran') ? 'is-invalid' : ''), 'id' => 'id_tahun_ajaran']) !!}
            @error('id_tahun_ajaran')
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
    <div class="row">
        <div class="form-group col-lg-6">
            <label for="status">Status</label>
            {!! Form::select('status', [ 'Aktif' => 'Aktif', 'Tidak Aktif' => 'Tidak Aktif'], null, ['class' => 'form-control '.($errors->has('status') ? 'is-invalid' : ''), 'id' => 'status']) !!}
            @error('status')
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
    <x-slot name="title">Semester Mahasiswa</x-slot>
    <x-slot name="modalPosition">modal-dialog-centered</x-slot>
    @csrf
    @method('put')
    <div class="row">
        <div class="form-group col-lg-12">
            <label for="id_mahasiswa">Mahasiswa</label>
            {!! Form::select('id_mahasiswa', $mahasiswa, NULL, ['class' => 'form-control '.($errors->has('id_mahasiswa') ? 'is-invalid' : ''), 'id' => 'id_mahasiswa']) !!}
            @error('id_mahasiswa')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>  
    <div class="row">
        <div class="form-group col-lg-6">
            <label for="id_tahun_ajaran">Tahun Ajaran</label>
            {!! Form::select('id_tahun_ajaran', $tahun_ajaran, NULL, ['class' => 'form-control '.($errors->has('id_tahun_ajaran') ? 'is-invalid' : ''), 'id' => 'id_tahun_ajaran']) !!}
            @error('id_tahun_ajaran')
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
    <div class="row">
        <div class="form-group col-lg-6">
            <label for="status">Status</label>
            {!! Form::select('status', [ 'Aktif' => 'Aktif', 'Tidak Aktif' => 'Tidak Aktif'], null, ['class' => 'form-control '.($errors->has('status') ? 'is-invalid' : ''), 'id' => 'status']) !!}
            @error('status')
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

<x-modal class="generate-form" id="modal-form">
    <x-slot name="title">Semester Mahasiswa</x-slot>
    <x-slot name="modalPosition">modal-dialog-centered</x-slot>
    @csrf
    <input type="hidden" name="prodi">
    <input type="hidden" name="tahun_ajaran">
    <input type="hidden" name="semester">

    <x-datatable 
    :id="'list_mahasiswa'"
    :route="route('admin_prodi.semester_mahasiswa.mahasiswa_data_index')" 
    :table="[
        ['title' => 'Pilih', 'data' => 'checkbox', 'name' => 'checkbox', 'orderable' => 'false', 'searchable' => 'false', 'width' => '10'],  
        ['title' => 'NIM', 'data' => 'nim', 'name' => 'nim'],                         
        ['title' => 'Nama Mahasiswa', 'data' => 'nama_mahasiswa', 'name' => 'nama_mahasiswa', 'classname' => 'text-left'], 
        ['title' => 'Jenis Kelamin', 'data' => 'jenis_kelamin', 'name' => 'jenis_kelamin'],              
    ]"
    :filter="[
        ['data' => 'semester', 'value' => '$(`#semester`).val()'],
        ['data' => 'tahun_ajaran', 'value' => '$(`#tahun_ajaran`).val()']
    ]"
    />
    <x-slot name="footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </x-slot>
</x-modal>

{{-- <x-modal.generate>
<div class="form-group col-lg-6">
    <label for="id_mahasiswa">Mahasiswa</label>
    {!! Form::select('id_mahasiswa', $mahasiswa, NULL, ['class' => 'form-control '.($errors->has('id_mahasiswa') ? 'is-invalid' : ''), 'id' => 'id_mahasiswa']) !!}
    @error('id_mahasiswa')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>
</x-modal.generate> --}}

@endsection

@push('js')
    <script>

        $( document ).ready(function() {
            $(document).on('change','#semester, #tahun_ajaran',function(){
                table.ajax.reload();
            });

            $(document).on('change','##semester, #tahun_ajaran',function(){
                list_mahasiswa.ajax.reload();
            });

            $(document).on('change','#semester, #tahun_ajaran',function(){
                if($('#prodi').val() && $('#semester').val() && $('#tahun_ajaran').val()) {
                    $('.btn-generate').attr('disabled', false);
                } else {
                    $('.btn-generate').attr('disabled', true);
                }
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
            var id_tahun_ajaran = $(this).data('id_tahun_ajaran');
            var id_mahasiswa = $(this).data('id_mahasiswa');
            var id_semester = $(this).data('id_semester');
            var id_prodi = $(this).data('id_prodi');
            var status = $(this).data('status');

            $('[name=id_tahun_ajaran]').val(id_tahun_ajaran);
            $('[name=id_mahasiswa]').val(id_mahasiswa);
            $('[name=id_semester]').val(id_semester);
            $('[name=id_prodi]').val(id_prodi);
            $('[name=status]').val(status);

        });

        $('.btn-generate').on('click', function () {
            $('.generate-form').modal('show');
            $('.generate-form form')[0].reset();
            $('.generate-form form').attr('action',  $(this).data('route'));
            $('[name=_method]').val('post');

            let route = $(this).data('route');
            let prodi = $('#prodi').val();
            let tahun_ajaran = $('#tahun_ajaran').val();
            let semester = $('#semester').val();

            $('[name=prodi]').val(prodi);
            $('[name=tahun_ajaran]').val(tahun_ajaran);
            $('[name=semester]').val(semester);
        });
        
    </script>
@endpush