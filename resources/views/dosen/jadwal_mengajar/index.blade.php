@extends('layouts.app')
@section('title', 'Jadwal Mengajar')

@section('content')
<x-header>
    Jadwal Mengajar
</x-header>

<x-card-table>
    <x-slot name="title">Data Jadwal Mengajar</x-slot>
    
    <x-datatable 
    :route="route('dosen.jadwal_mengajar.data_index')" 
    :table="[
        ['title' => 'No.', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => 'false', 'searchable' => 'false', 'width' => '10'],
        ['title' => 'Nama Mata Kuliah', 'data' => 'nama_matkul', 'name' => 'nama_matkul', 'classname' => 'text-left'],
        ['title' => 'Kode MK', 'data' => 'kode_matkul', 'name' => 'kode_matkul'],
        ['title' => 'Kelas', 'data' => 'kelas', 'name' => 'kelas', 'classname' => 'text-left'],
        ['title' => 'Ruang', 'data' => 'ruangan', 'name' => 'ruangan'],
        ['title' => 'Waktu', 'data' => 'jadwal', 'name' => 'jadwal', 'classname' => 'text-left'],
        ['title' => 'JmL Peserta', 'data' => 'jumlah_peserta', 'name' => 'jumlah_peserta'],
        ['title' => 'Ket.', 'data' => 'action', 'orderable' => 'false', 'searchable' => 'false'],
    ]"
    />
</x-card-table>

<x-modal class="modal-form" id="modal-form">
    <x-slot name="title">Kontrak</x-slot>
    <x-slot name="modalPosition">modal-dialog-centered</x-slot>
    
    @csrf 
    @method('put')
    
    <div class="row">
        <div class="form-group col-lg-12">
            <label for="kontrak_belajar">Kontrak Belajar</label>
            {!! Form::textarea('kontrak_belajar', null, ['class' => 'form-control '.($errors->has('kontrak_belajar') ? 'is-invalid' : ''), 'id' => 'kontrak_belajar', 'rows' => 3]) !!}
            @error('kontrak_belajar')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="row">
        <div class="form-group col-lg-6">
            <label for="path_kontrak_belajar" class="preview1">Path Kontrak</label>
            <div class="custom-file">
                <input type="file" name="path_kontrak_belajar" class="custom-file-input {{ $errors->has('path_kontrak_belajar') ? 'is-invalid' : '' }}" id="path_kontrak_belajar">
                <label class="custom-file-label" for="path_kontrak_belajar">Choose file</label>
            </div>
            @error('path_kontrak_belajar')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group col-lg-6">
            <label for="path_rpp" class="preview2">Path RPP</label>
            <div class="custom-file">
                <input type="file" name="path_rpp" class="custom-file-input {{ $errors->has('path_rpp') ? 'is-invalid' : '' }}" id="path_rpp">
                <label class="custom-file-label" for="path_rpp">Choose file</label>
            </div>
            @error('path_rpp')
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
    $(document).on('click', '.btn_edit', function () {
        $('.modal-form').modal('show');
        $('.modal-form form')[0].reset();
        $('.modal-form form').attr('action',  $(this).data('route'));
        $('[name=_method]').val('put');

        $('[name=kontrak_belajar]').val($(this).data('kontrak_belajar'));

        if ($(this).data('path_kontrak_belajar') != undefined) {
            $('.preview1').html(`
                Path File
                <a target="_blank" class="btn btn-link text-dark m-0 p-0" href="${$(this).data('path_kontrak_belajar')}">Lihat</a>
            `)
            .addClass('d-flex justify-content-between align-items-center m-0 p-0');
        }

        if ($(this).data('path_rpp') != undefined) {
            $('.preview2').html(`
                Path File
                <a target="_blank" class="btn btn-link text-dark m-0 p-0" href="${$(this).data('path_rpp')}">Lihat</a>
            `)
            .addClass('d-flex justify-content-between align-items-center m-0 p-0');
        }
    });
</script>
@endpush