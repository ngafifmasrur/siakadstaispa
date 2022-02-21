@extends('layouts.app')
@section('title', 'Penugasan Dosen')

@section('content')

<x-header>
    Penugasan Dosen Belum NIDN
</x-header>

<x-card>
    <div class="row">
        <div class="form-group col-lg-3">
            <label for="prodi">Program Studi</label>
            {!! Form::select('prodi', $prodi, null, ['class' => 'form-control', 'id' => 'prodi']) !!}
        </div>
        <div class="form-group col-lg-3">
            <label for="tahun_ajaran">Tahun Ajaran</label>
            {!! Form::select('tahun_ajaran', $tahun_ajaran, $tahun_ajaran_id, ['class' => 'form-control', 'id' => 'tahun_ajaran']) !!}
        </div>
    </div>
</x-card>

<x-card-table>
    <x-slot name="title">Data Penugasan Dosen Belum NIDN</x-slot>
    <x-slot name="button">
        <a class="btn btn-app btn-sm btn-primary add-form" data-url="{{ route('admin.penugasan_dosen.store')}}" href="#"><i class="fa fa-plus mr-2"></i>Tambah</a>
    </x-slot>

    <x-datatable 
    :route="route('admin.penugasan_dosen.data_index')" 
    :table="[
        ['title' => 'No.', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => 'false', 'searchable' => 'false', 'width' => '10'],                            
        ['title' => 'Nama Dosen', 'data' => 'nama_dosen', 'name' => 'nama_dosen'],
        ['title' => 'Tahun Ajaran', 'data' => 'nama_tahun_ajaran', 'name' => 'nama_tahun_ajaran'],
        ['title' => 'Program Studi', 'data' => 'nama_program_studi', 'name' => 'nama_program_studi', 'classname' => 'text-left'],
        ['title' => 'Tgl Surat Tugas', 'data' => 'tanggal_surat_tugas', 'name' => 'tanggal_surat_tugas'],
        ['title' => 'Mulai Surat Tugas', 'data' => 'mulai_surat_tugas', 'name' => 'mulai_surat_tugas'],
        ['title' => 'Aksi', 'data' => 'action', 'orderable' => 'false', 'searchable' => 'false'],
    ]"
    :filter="[
        ['data' => 'prodi', 'value' => '$(`#prodi`).val()'],
        ['data' => 'tahun_ajaran', 'value' => '$(`#tahun_ajaran`).val()']
    ]"
    />

</x-card-table>

<x-modal.delete/>


<x-modal class="modal-form" id="modal-form">
    <x-slot name="title">Penugasan Dosen Belum NIDN</x-slot>
    <x-slot name="modalPosition">modal-dialog-centered</x-slot>
    
    @csrf 
    @method('post')
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="id_dosen">Dosen</label>
            {!! Form::select('id_dosen', $dosen, null, ['class' => 'form-control', 'id' => 'id_dosen']) !!}
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="id_tahun_ajaran">Tahun Ajaran</label>
            {!! Form::select('id_tahun_ajaran', $tahun_ajaran, $tahun_ajaran_id, ['class' => 'form-control', 'id' => 'id_tahun_ajaran']) !!}
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
            <label for="nomor_surat_tugas">Nomor Surat Tugas</label>
            {!! Form::text('nomor_surat_tugas', null, ['class' => 'form-control', 'id' => 'nomor_surat_tugas']) !!}
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="tanggal_surat_tugas">Tanggal Surat Tugas</label>
            {!! Form::date('tanggal_surat_tugas', null, ['class' => 'form-control', 'id' => 'sks_praktanggal_surat_tugastek']) !!}
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="mulai_surat_tugas">Mulai Surat Tugas</label>
            {!! Form::date('mulai_surat_tugas', null, ['class' => 'form-control', 'id' => 'mulai_surat_tugas']) !!}
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
            $(document).on('change','#prodi, #tahun_ajaran',function(){
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
            var id_dosen = $(this).data('id_dosen');
            var id_tahun_ajaran = $(this).data('id_tahun_ajaran');
            var id_prodi = $(this).data('id_prodi');
            var nomor_surat_tugas = $(this).data('nomor_surat_tugas');
            var tanggal_surat_tugas = $(this).data('tanggal_surat_tugas');
            var mulai_surat_tugas = $(this).data('mulai_surat_tugas');

            $('[name=id_dosen]').val(id_dosen);
            $('[name=id_tahun_ajaran]').val(id_tahun_ajaran);
            $('[name=id_prodi]').val(id_prodi);
            $('[name=nomor_surat_tugas]').val(nomor_surat_tugas);
            $('[name=tanggal_surat_tugas]').val(tanggal_surat_tugas);
            $('[name=mulai_surat_tugas]').val(mulai_surat_tugas);
            $('select').selectpicker('refresh');

        });
    </script>
@endpush