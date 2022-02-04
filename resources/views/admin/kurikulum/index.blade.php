@extends('layouts.app')
@section('title', 'Kurikulum')

@section('content')
<x-header>
    Kurikulum
</x-header>

<x-card>
    <div class="row">
        <div class="form-group col-lg-3">
            <label for="prodi">Program Studi</label>
            {!! Form::select('prodi', $prodi, null, ['class' => 'form-control', 'id' => 'prodi']) !!}
        </div>
        <div class="form-group col-lg-3">
            <label for="semester">Semester</label>
            {!! Form::select('semester', $semester, null, ['class' => 'form-control', 'id' => 'semester']) !!}
        </div>
    </div>
</x-card>

<x-card-table>
    <x-slot name="title">Data Kurikulum</x-slot>
    <x-slot name="button">
        <a class="btn btn-app btn-sm btn-primary add-form" data-url="{{ route('admin.kurikulum.store') }}" href="#"><i class="fa fa-plus mr-2"></i>Tambah</a>
    </x-slot>

    <x-datatable 
    :route="route('admin.kurikulum.data_index')" 
    :table="[
        ['title' => 'No.', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => 'false', 'searchable' => 'false', 'width' => '10'],
        ['title' => 'Nama Kurikulum', 'data' => 'nama_kurikulum', 'name' => 'nama_kurikulum', 'classname' => 'text-left'],
        ['title' => 'Program Studi', 'data' => 'nama_program_studi', 'name' => 'nama_program_studi', 'classname' => 'text-left'],
        ['title' => 'Semester', 'data' => 'nama_semester', 'name' => 'nama_semester', 'classname' => 'text-left'],
        ['title' => 'Jumlah SKS Lulus', 'data' => 'jumlah_sks_lulus', 'name' => 'jumlah_sks_lulus'],
        ['title' => 'Jumlah SKS Wajib', 'data' => 'jumlah_sks_wajib', 'name' => 'jumlah_sks_wajib'],
        ['title' => 'Jumlah SKS Pilihan', 'data' => 'jumlah_sks_pilihan', 'name' => 'jumlah_sks_pilihan'],
        ['title' => 'Jumlah SKS Matkul Wajib', 'data' => 'jumlah_sks_mata_kuliah_wajib', 'name' => 'jumlah_sks_mata_kuliah_wajib'],
        ['title' => 'Jumlah SKS Matkul Pilihan', 'data' => 'jumlah_sks_mata_kuliah_pilihan', 'name' => 'jumlah_sks_mata_kuliah_pilihan'],
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
    <x-slot name="title">Kurikulum</x-slot>
    <x-slot name="modalPosition">modal-dialog-centered</x-slot>
    
    @csrf 
    @method('post')
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="kode_program_studi">Nama Kurikulum</label>
            {!! Form::text('nama_kurikulum', null, ['class' => 'form-control', 'id' => 'nama_kurikulum']) !!}
        </div>
    </div>
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
        <div class="form-group col-lg-12">
            <label for="jumlah_sks_lulus">Jumlah SKS Lulus</label>
            {!! Form::number('jumlah_sks_lulus', null, ['class' => 'form-control', 'id' => 'jumlah_sks_lulus']) !!}
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="jumlah_sks_lulus">Jumlah SKS Wajib</label>
            {!! Form::number('jumlah_sks_wajib', null, ['class' => 'form-control', 'id' => 'jumlah_sks_wajib']) !!}
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="jumlah_sks_lulus">Jumlah SKS Pilihan</label>
            {!! Form::number('jumlah_sks_pilihan', null, ['class' => 'form-control', 'id' => 'jumlah_sks_pilihan']) !!}
        </div>
    </div>

    <x-slot name="footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </x-slot>
</x-modal>

<x-modal class="edit-form" id="modal-form">
    <x-slot name="title">Kurikulum</x-slot>
    <x-slot name="modalPosition">modal-dialog-centered</x-slot>
    @csrf
    @method('put')
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="kode_program_studi">Nama Kurikulum</label>
            {!! Form::text('nama_kurikulum', null, ['class' => 'form-control', 'id' => 'nama_kurikulum']) !!}
        </div>
    </div>
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
        <div class="form-group col-lg-12">
            <label for="jumlah_sks_lulus">Jumlah SKS Lulus</label>
            {!! Form::number('jumlah_sks_lulus', null, ['class' => 'form-control', 'id' => 'jumlah_sks_lulus']) !!}
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="jumlah_sks_lulus">Jumlah SKS Wajib</label>
            {!! Form::number('jumlah_sks_wajib', null, ['class' => 'form-control', 'id' => 'jumlah_sks_wajib']) !!}
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="jumlah_sks_lulus">Jumlah SKS Pilihan</label>
            {!! Form::number('jumlah_sks_pilihan', null, ['class' => 'form-control', 'id' => 'jumlah_sks_pilihan']) !!}
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