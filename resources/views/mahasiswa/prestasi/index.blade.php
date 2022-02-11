@extends('layouts.app')
@section('title', 'Prestasi')

@section('content')

<x-header>
    Prestasi
</x-header>

<x-card-table>
    <x-slot name="title">Data Prestasi</x-slot>
    <x-slot name="button">
        <a class="float-right btn btn-sm btn-primary add-form" data-url="#" href="#"><i data-feather="plus" class="mr-2"></i>Tambah</a>
    </x-slot>

    <x-datatable 
    :route="route('mahasiswa.prestasi_mahasiswa.data_index')" 
    :table="[
        ['title' => 'No.', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => 'false', 'searchable' => 'false', 'width' => '10'],                            
        ['title' => 'Jenis Prestasi', 'data' => 'nama_jenis_prestasi', 'name' => 'nama_jenis_prestasi'],
        ['title' => 'Tingkat Prestasi', 'data' => 'nama_tingkat_prestasi', 'name' => 'nama_tingkat_prestasi', 'classname' => 'text-left'],
        ['title' => 'Nama Prestasi', 'data' => 'nama_prestasi', 'name' => 'nama_prestasi'],
        ['title' => 'Tahun', 'data' => 'tahun_prestasi', 'name' => 'tahun_prestasi', 'classname' => 'text-left'],
        ['title' => 'Penyelenggara', 'data' => 'penyelenggara', 'name' => 'penyelenggara', 'classname' => 'text-left'],
        ['title' => 'Peringkat', 'data' => 'peringkat', 'name' => 'peringkat', 'classname' => 'text-left'],
        ['title' => 'Aksi', 'data' => 'action', 'orderable' => 'false', 'searchable' => 'false'],
    ]"
    />

</x-card-table>

<x-modal.delete/>

<x-modal class="modal-form" id="modal-form">
    <x-slot name="title">Prestasi</x-slot>
    <x-slot name="modalPosition">modal-dialog-centered</x-slot>
    
    @php
        $years = [];
        for ($year=2000; $year <= date('Y'); $year++) $years[$year] = $year;
    @endphp

    @csrf 
    @method('post')
    <div class="row">
        <div class="form-group col-lg-6">
            <label for="id_jenis_prestasi">Jenis Prestasi</label>
            {!! Form::select('id_jenis_prestasi', $jenisPrestasi, null, ['class' => 'form-control '.($errors->has('id_jenis_prestasi') ? 'is-invalid' : ''), 'id' => 'id_jenis_prestasi']) !!}
            @error('id_jenis_prestasi')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="form-group col-lg-6">
            <label for="id_tingkat_prestasi">Tingkat Prestasi</label>
            {!! Form::select('id_tingkat_prestasi', $tingkatPrestasi, null, ['class' => 'form-control '.($errors->has('id_tingkat_prestasi') ? 'is-invalid' : ''), 'id' => 'id_tingkat_prestasi']) !!}
            @error('id_tingkat_prestasi')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
    </div>

    <div class="row">
        <div class="form-group col-lg-12">
            <label for="nama_prestasi">Nama Prestasi</label>
            {!! Form::text('nama_prestasi', null, ['class' => 'form-control '.($errors->has('nama_prestasi') ? 'is-invalid' : ''), 'id' => 'nama_prestasi']) !!}
            @error('nama_prestasi')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>

    <div class="row">
        <div class="form-group col-lg-6">
            <label for="tahun_prestasi">Tahun</label>
            {!! Form::select('tahun_prestasi', $years, date('Y'), ['class' => 'form-control '.($errors->has('tahun_prestasi') ? 'is-invalid' : ''), 'id' => 'tahun_prestasi']) !!}
            @error('tahun_prestasi')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group col-lg-6">
            <label for="penyelenggara">Penyelenggara</label>
            {!! Form::text('penyelenggara', null, ['class' => 'form-control '.($errors->has('penyelenggara') ? 'is-invalid' : ''), 'id' => 'penyelenggara']) !!}
            @error('penyelenggara')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>

    <div class="row">
        <div class="form-group col-lg-6">
            <label for="peringkat">Peringkat</label>
            {!! Form::number('peringkat', null, ['class' => 'form-control '.($errors->has('peringkat') ? 'is-invalid' : ''), 'id' => 'peringkat']) !!}
            @error('peringkat')
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
            
            var id_tingkat_prestasi = $(this).data('id_tingkat_prestasi');
            var nama_prestasi = $(this).data('nama_prestasi');
            var tahun_prestasi = $(this).data('tahun_prestasi');
            var penyelenggara = $(this).data('penyelenggara');
            var peringkat = $(this).data('peringkat');

            $('[name=id_tingkat_prestasi]').val(id_tingkat_prestasi);
            $('[name=nama_prestasi]').val(nama_prestasi);
            $('[name=tahun_prestasi]').val(tahun_prestasi);
            $('[name=penyelenggara]').val(penyelenggara);
            $('[name=peringkat]').val(peringkat);
        });
    </script>
@endpush