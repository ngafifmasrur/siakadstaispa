@extends('layouts.app')
@section('title', 'Dosen Pembimbing')

@section('content')

<x-header>
    Dosen Pembimbing
</x-header>


<x-card-table>
    <x-slot name="title">Data Dosen Pembimbing</x-slot>
    <x-slot name="button">
        <a class="btn btn-app btn-sm btn-primary add-form" data-url="{{ route('admin.dosen_pembimbing.store')}}" href="#"><i class="fa fa-plus mr-2"></i>Tambah</a>
    </x-slot>

    <x-datatable 
    :route="route('admin.dosen_pembimbing.data_index')" 
    :table="[
        ['title' => 'No.', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => 'false', 'searchable' => 'false', 'width' => '10'],                            
        ['title' => 'Judul', 'data' => 'judul', 'name' => 'judul', 'classname' => 'text-left'],
        ['title' => 'Kategori Kegiatan', 'data' => 'nama_kategori_kegiatan', 'name' => 'nama_kategori_kegiatan', 'classname' => 'text-left'],
        ['title' => 'Dosen Pembimbing', 'data' => 'nama_dosen', 'name' => 'nama_dosen', 'classname' => 'text-left'],
        ['title' => 'Pembimbing ke', 'data' => 'pembimbing_ke', 'name' => 'pembimbing_ke', 'classname' => 'text-center'],
        ['title' => 'Aksi', 'data' => 'action', 'orderable' => 'false', 'searchable' => 'false'],
    ]"
    />

</x-card-table>

<x-modal.delete/>


<x-modal class="modal-form" id="modal-form">
    <x-slot name="title">Dosen Pembimbing</x-slot>
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
            <label for="id_aktivitas">Aktivitas Mahasiswa</label>
            {!! Form::select('id_aktivitas', $aktivitas, null, ['class' => 'form-control', 'id' => 'id_aktivitas']) !!}
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="id_kategori_kegiatan">Kategori Kegiatan</label>
            {!! Form::select('id_kategori_kegiatan', $kategori_kegiatan, null, ['class' => 'form-control', 'id' => 'id_kategori_kegiatan']) !!}
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="pembimbing_ke">Pembimbing ke</label>
            {!! Form::number('pembimbing_ke', null, ['class' => 'form-control', 'id' => 'pembimbing_ke', 'min' => 1]) !!}
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
            var id_dosen = $(this).data('id_dosen');
            var id_kategori_kegiatan = $(this).data('id_kategori_kegiatan');
            var id_aktivitas = $(this).data('id_aktivitas');
            var pembimbing_ke = $(this).data('pembimbing_ke');

            $('[name=id_dosen]').val(id_dosen);
            $('[name=id_kategori_kegiatan]').val(id_kategori_kegiatan);
            $('[name=id_aktivitas]').val(id_aktivitas);
            $('[name=pembimbing_ke]').val(pembimbing_ke);
            $('select').selectpicker('refresh');

        });
    </script>
@endpush