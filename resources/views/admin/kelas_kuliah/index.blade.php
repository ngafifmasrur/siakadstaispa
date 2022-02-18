@extends('layouts.app')
@section('title', 'Kelas Kuliah')

@section('content')

<x-header>
    Kelas Kuliah
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
    </div>
</x-card>

<x-card-table>
    <x-slot name="title">Data Kelas Kuliah</x-slot>
    <x-slot name="button">
        <a class="btn btn-app btn-sm btn-primary add-form" data-url="{{ route('admin.kelas_kuliah.store') }}" href="#"><i class="fa fa-plus mr-2"></i>Tambah</a>
    </x-slot>
    
    <x-datatable 
    :route="route('admin.kelas_kuliah.data_index')" 
    :table="[
        ['title' => 'No.', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => 'false', 'searchable' => 'false', 'width' => '10'],                            
        ['title' => 'Program Studi', 'data' => 'nama_program_studi', 'name' => 'nama_program_studi', 'classname' => 'text-left'],
        {{-- ['title' => 'Semester', 'data' => 'nama_semester', 'name' => 'nama_semester', 'classname' => 'text-left'], --}}
        ['title' => 'Kode MK', 'data' => 'kode_mata_kuliah', 'name' => 'kode_mata_kuliah'],
        ['title' => 'Mata Kuliah', 'data' => 'nama_mata_kuliah', 'name' => 'nama_mata_kuliah', 'classname' => 'text-left'],
        ['title' => 'Dosen', 'data' => 'nama_dosen', 'name' => 'nama_dosen', 'classname' => 'text-left'],
        ['title' => 'Kelas', 'data' => 'nama_kelas_kuliah', 'name' => 'nama_kelas_kuliah', 'classname' => 'text-center'],
        ['title' => 'Jadwal', 'data' => 'jadwal', 'name' => 'jadwal', 'classname' => 'text-center'],
        ['title' => 'Dosen', 'data' => 'dosen', 'name' => 'dosen'],
        ['title' => 'Mahasiswa', 'data' => 'mahasiswa', 'name' => 'mahasiswa'],
        ['title' => 'Aksi', 'data' => 'action', 'orderable' => 'false', 'searchable' => 'false'],
    ]"
    :filter="[
        ['data' => 'id_prodi', 'value' => '$(`#prodi`).val()'],
        ['data' => 'id_semester', 'value' => '$(`#semester`).val()']
    ]"
    />
</x-card-table>

<x-modal.delete/>

<x-modal class="modal-form" id="modal-form">
    <x-slot name="title">Kelas Kuliah</x-slot>
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
        <div class="form-group col-lg-12">
            <label for="id_semester">Semester</label>
            {!! Form::select('id_semester', $semester, $semester_id, ['class' => 'form-control '.($errors->has('id_semester') ? 'is-invalid' : ''), 'id' => 'id_semester']) !!}
            @error('id_semester')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="id_matkul">Mata Kuliah</label>
            <select name="id_matkul" id="id_matkul" class="form-control">
                <option value="">Pilih Program Studi Dahulu</option>
            </select>
            @error('id_matkul')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group col-lg-12">
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
        <div class="form-group col-lg-6">
            <label for="jam_mulai">Jam Mulai</label>
            {!! Form::time('jam_mulai', null, ['class' => 'form-control '.($errors->has('jam_mulai') ? 'is-invalid' : ''), 'id' => 'jam_mulai']) !!}
            @error('jam_mulai')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group col-lg-6">
            <label for="jam_akhir">Jam Selesai</label>
            {!! Form::time('jam_akhir', null, ['class' => 'form-control '.($errors->has('jam_akhir') ? 'is-invalid' : ''), 'id' => 'jam_akhir']) !!}
            @error('jam_akhir')
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

@push('css')
    <style>
        .row {
            display: flex!important;
        }
    </style>
@endpush

@push('js')
    <script>
        $("#id_prodi").change(function(){
            $.ajax({
                url: "{{ route('admin.kelas_kuliah.mata_kuliah_by_prodi') }}?id_prodi=" + $(this).val(),
                method: 'GET',
                success: function(data) {
                    $('#id_matkul').html('<option value="">Pilih Mata Kuliah</option>');
                    $.each(data, function(index, value) {
                        $('#id_matkul').append('<option value="' + value.id_matkul+ '">' + value.matkul_kode+ '</option>');
                    });
                    $('select').selectpicker('refresh');
                }
            });
        });

        $( document ).ready(function() {
            $(document).on('change','#prodi, #semester',function(){
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
            var id_prodi = $(this).data('prodi');
            var id_matkul = $(this).data('matkul');
            var id_semester = $(this).data('semester');
            var nama_kelas_kuliah = $(this).data('nama');
            var bahasan = $(this).data('bahasan');
            var tanggal_mulai = $(this).data('tanggal_mulai');
            var tanggal_akhir = $(this).data('tanggal_akhir');
            var hari = $(this).data('hari');
            var jam_mulai = $(this).data('jam_mulai');
            var jam_akhir = $(this).data('jam_akhir');

            $('[name=id_prodi]').val(id_prodi);
            $('[name=id_semester]').val(id_semester);
            $('[name=nama_kelas_kuliah]').val(nama_kelas_kuliah);
            $('[name=bahasan]').val(bahasan);
            $('[name=tanggal_mulai_efektif]').val(tanggal_mulai);
            $('[name=tanggal_akhir_efektif]').val(tanggal_akhir);
            $('[name=hari]').val(hari);
            $('[name=jam_mulai]').val(jam_mulai);
            $('[name=jam_akhir]').val(jam_akhir);

            $.ajax({
                url: "{{ route('admin.kelas_kuliah.mata_kuliah_by_prodi') }}?id_prodi=" + id_prodi,
                method: 'GET',
                success: function(data) {
                    $('#id_matkul').html('<option value="">Pilih Mata Kuliah</option>');
                    $.each(data, function(index, value) {
                        $('#id_matkul').append('<option value="' + value.id_matkul+ '" ' +'selected'+ '>' + value.matkul_kode+ '</option>');
                    });
                    $('select').selectpicker('refresh');
                }
            });

            $('[name=id_matkul]').val(id_matkul);
            $('select').selectpicker('refresh');

        });
    </script>
@endpush