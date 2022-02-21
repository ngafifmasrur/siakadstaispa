@extends('layouts.app')
@section('title', 'Periode Perkuliahan')

@push('css')
    <style>
        .row {
            display: flex!important;
        }
    </style>
@endpush

@section('content')

<x-header>
    Periode Perkuliahan
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
    <x-slot name="title">Data Periode Perkuliahan</x-slot>
    <x-slot name="button">
        <a class="btn btn-app btn-sm btn-primary add-form" data-url="{{ route('admin.periode_perkuliahan.store') }}" href="#"><i class="fa fa-plus mr-2"></i>Tambah</a>
    </x-slot>

    <x-datatable 
    :route="route('admin.periode_perkuliahan.data_index')" 
    :table="[
        ['title' => 'No.', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => 'false', 'searchable' => 'false', 'width' => '10'],                            
        ['title' => 'Program Studi', 'data' => 'nama_program_studi', 'name' => 'nama_program_studi', 'classname' => 'text-left'],
        ['title' => 'Semester', 'data' => 'nama_semester', 'name' => 'nama_semester', 'classname' => 'text-left'],
        ['title' => 'Jumlah Target Mahasiswa', 'data' => 'jumlah_target_mahasiswa_baru', 'name' => 'jumlah_target_mahasiswa_baru'],
        ['title' => 'Tgl Awal Perkuliahan', 'data' => 'tanggal_awal_perkuliahan', 'name' => 'tanggal_awal_perkuliahan'],
        ['title' => 'Tgl akhir Perkuliahan', 'data' => 'tanggal_akhir_perkuliahan', 'name' => 'tanggal_akhir_perkuliahan'],
        ['title' => 'Aksi', 'data' => 'action', 'orderable' => 'false', 'searchable' => 'false'],
    ]"
    :filter="[
        ['data' => 'prodi', 'value' => '$(`#prodi`).val()'],
        ['data' => 'semester', 'value' => '$(`#semester`).val()'],
    ]"
    />

</x-card-table>

<x-modal.delete/>

<x-modal class="modal-form" id="modal-form">
    <x-slot name="title">Periode Perkuliahan</x-slot>
    <x-slot name="modalPosition">modal-dialog-centered</x-slot>
    
    @csrf 
    @method('post')
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="id_prodi">Program Studi</label>
            {!! Form::select('id_prodi', $prodi, null, ['class' => 'form-control', 'id' => 'id_prodi']) !!}
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="id_semester">Semester</label>
            {!! Form::select('id_semester', $semester, null, ['class' => 'form-control', 'id' => 'id_semester']) !!}
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-6">
            <label for="jumlah_target_mahasiswa_baru">Jumlah Target Mahasiswa</label>
            {!! Form::number('jumlah_target_mahasiswa_baru', null, ['class' => 'form-control', 'id' => 'jumlah_target_mahasiswa_baru']) !!}
        </div>
        <div class="form-group col-lg-6">
            <label for="jumlah_pendaftar_ikut_seleksi">Jumlah Pendaftar Ikut Seleksi</label>
            {!! Form::number('jumlah_pendaftar_ikut_seleksi', null, ['class' => 'form-control', 'id' => 'jumlah_pendaftar_ikut_seleksi']) !!}
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-6">
            <label for="jumlah_pendaftar_lulus_seleksi">Jumlah Pendaftar Lulus Seleksi</label>
            {!! Form::number('jumlah_pendaftar_lulus_seleksi', null, ['class' => 'form-control', 'id' => 'jumlah_pendaftar_lulus_seleksi']) !!}
        </div>
        <div class="form-group col-lg-6">
            <label for="jumlah_daftar_ulang">Jumlah Daftar Ulang</label>
            {!! Form::number('jumlah_daftar_ulang', null, ['class' => 'form-control', 'id' => 'jumlah_daftar_ulang']) !!}
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-6">
            <label for="jumlah_mengundurkan_diri">Jumlah Mengundurkan Diri</label>
            {!! Form::number('jumlah_mengundurkan_diri', null, ['class' => 'form-control', 'id' => 'jumlah_mengundurkan_diri']) !!}
        </div>
        <div class="form-group col-lg-6">
            <label for="jumlah_minggu_pertemuan">Jumlah Minggu Pertemuan</label>
            {!! Form::number('jumlah_minggu_pertemuan', null, ['class' => 'form-control', 'id' => 'jumlah_minggu_pertemuan']) !!}
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-6">
            <label for="tanggal_awal_perkuliahan">Tanggal Awal Perkuliahan</label>
            {!! Form::date('tanggal_awal_perkuliahan', null, ['class' => 'form-control', 'id' => 'tanggal_awal_perkuliahan']) !!}
        </div>
        <div class="form-group col-lg-6">
            <label for="tanggal_akhir_perkuliahan">Tanggal Akhir Perkuliahan</label>
            {!! Form::date('tanggal_akhir_perkuliahan', null, ['class' => 'form-control', 'id' => 'tanggal_akhir_perkuliahan']) !!}
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
            var id_prodi = $(this).data('id_prodi');
            var id_semester = $(this).data('id_semester');
            var jumlah_target_mahasiswa_baru = $(this).data('jumlah_target_mahasiswa_baru');
            var tanggal_awal_perkuliahan = $(this).data('tanggal_awal_perkuliahan');
            var tanggal_akhir_perkuliahan = $(this).data('tanggal_akhir_perkuliahan');

            $('[name=id_prodi]').val(id_prodi);
            $('[name=id_semester]').val(id_semester);
            $('[name=jumlah_target_mahasiswa_baru]').val(jumlah_target_mahasiswa_baru);
            $('[name=tanggal_awal_perkuliahan]').val(tanggal_awal_perkuliahan);
            $('[name=tanggal_akhir_perkuliahan]').val(tanggal_akhir_perkuliahan);
            $('select').selectpicker('refresh');

        });
    </script>
@endpush