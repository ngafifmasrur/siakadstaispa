@extends('layouts.app')
@section('title', 'Aktivitas Mahasiswa')

@section('content')

<x-header>
    Aktivitas Mahasiswa
</x-header>


<x-card-table>
    <x-slot name="title">Data Aktivitas Mahasiswa</x-slot>
    <x-slot name="button">
        <a class="btn btn-app btn-sm btn-primary add-form" data-url="{{ route('mahasiswa.aktivitas_mahasiswa.store')}}" href="#"><i class="fa fa-plus mr-2"></i>Tambah</a>
    </x-slot>

    <x-datatable 
    :route="route('mahasiswa.aktivitas_mahasiswa.data_index')" 
    :table="[
        ['title' => 'No.', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => 'false', 'searchable' => 'false', 'width' => '10'],                            
        ['title' => 'Judul', 'data' => 'judul', 'name' => 'judul', 'classname' => 'text-left'],
        ['title' => 'Jenis Anggota', 'data' => 'nama_jenis_anggota', 'name' => 'nama_jenis_anggota'],
        ['title' => 'Jenis Aktivitas', 'data' => 'nama_jenis_aktivitas', 'name' => 'nama_jenis_aktivitas'],
        ['title' => 'Program Studi', 'data' => 'nama_prodi', 'name' => 'nama_prodi'],
        ['title' => 'Pembimbing ke', 'data' => 'pembimbing_ke', 'name' => 'pembimbing_ke', 'classname' => 'text-center'],
        ['title' => 'Aksi', 'data' => 'action', 'orderable' => 'false', 'searchable' => 'false'],
    ]"
    />

</x-card-table>

<x-modal.delete/>


<x-modal class="modal-form" id="modal-form">
    <x-slot name="title">Aktivitas Mahasiswa</x-slot>
    <x-slot name="modalPosition">modal-dialog-centered</x-slot>
    
    @csrf 
    @method('post')
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="jenis_anggota">Jenis Anggota</label>
            {!! Form::select('jenis_anggota', [0 => 'Personal', 1 => 'Kelompok'], null, ['class' => 'form-control', 'id' => 'jenis_anggota']) !!}
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="id_jenis_aktivitas">Jenis Aktivitas</label>
            {!! Form::select('id_jenis_aktivitas', $jenis_aktivitas, null, ['class' => 'form-control', 'id' => 'id_jenis_aktivitas']) !!}
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
            {!! Form::select('id_semester', $semester, $semester_id, ['class' => 'form-control', 'id' => 'id_semester']) !!}
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="judul">Judul</label>
            {!! Form::text('judul', null, ['class' => 'form-control', 'id' => 'judul']) !!}
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
        // $( document ).ready(function() {
        //     $(document).on('change','#prodi, #tahun_ajaran',function(){
        //         table.ajax.reload();
        //     });
        // });


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
            var jenis_anggota = $(this).data('jenis_anggota');
            var id_jenis_aktivitas = $(this).data('id_jenis_aktivitas');
            var id_prodi = $(this).data('id_prodi');
            var id_semester = $(this).data('id_semester');
            var judul = $(this).data('judul');

            $('[name=jenis_anggota]').val(jenis_anggota);
            $('[name=id_jenis_aktivitas]').val(id_jenis_aktivitas);
            $('[name=id_prodi]').val(id_prodi);
            $('[name=id_semester]').val(id_semester);
            $('[name=judul]').val(judul);
            $('select').selectpicker('refresh');

        });
    </script>
@endpush