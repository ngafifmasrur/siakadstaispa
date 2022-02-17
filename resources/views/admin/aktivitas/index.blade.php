@extends('layouts.app')
@section('title', 'Kegiatan Mahasiswa')

@section('content')

<x-header>
    Kegiatan Mahasiswa
</x-header>

<x-card-table>
    <x-slot name="title">Data Kegiatan Mahasiswa</x-slot>
    <x-slot name="button">
        <a class="float-right btn btn-sm btn-outline-primary add-form" data-url="#" href="#"><i data-feather="plus" class="mr-2"></i>Tambah</a>
    </x-slot>

    <x-datatable 
    :route="route('admin.aktivitas.data_index')" 
    :table="[
        ['title' => 'No.', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => 'false', 'searchable' => 'false', 'width' => '10'],                            
        ['title' => 'Jenis Aktivitas', 'data' => 'nama_jenis_aktivitas', 'name' => 'nama_jenis_aktivitas'],
        ['title' => 'Prodi', 'data' => 'nama_prodi', 'name' => 'nama_prodi', 'classname' => 'text-left'],
        ['title' => 'Semester', 'data' => 'nama_semester', 'name' => 'nama_semester'],
        ['title' => 'Judul', 'data' => 'judul', 'name' => 'judul', 'classname' => 'text-left'],
        {{-- ['title' => 'Anggota', 'data' => 'anggota', 'name' => 'anggota', 'classname' => 'text-center'], --}}
        ['title' => 'Aksi', 'data' => 'action', 'orderable' => 'false', 'searchable' => 'false'],
    ]"
    />

</x-card-table>

<x-modal.delete/>

<x-modal class="modal-form" id="modal-form">
    <x-slot name="title">Kegiatan</x-slot>
    <x-slot name="modalPosition">modal-dialog-centered</x-slot>
    
    @csrf 
    @method('post')
    <div class="row">
        <div class="form-group col-lg-6">
            <label for="jenis_kegiatan">Jenis Kegiatan</label>
            {!! Form::select('jenis_kegiatan', $jenisAktivitas, null, ['class' => 'form-control '.($errors->has('jenis_kegiatan') ? 'is-invalid' : ''), 'id' => 'jenis_kegiatan']) !!}
            @error('jenis_kegiatan')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="form-group col-lg-6">
            <label for="id_prodi">Prodi</label>
            {!! Form::select('id_prodi', $prodi, null, ['class' => 'form-control '.($errors->has('id_prodi') ? 'is-invalid' : ''), 'id' => 'id_prodi']) !!}
            @error('id_prodi')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
    </div>

    <div class="row">
        <div class="form-group col-lg-6">
            <label for="id_semester">Semester</label>
            {!! Form::select('id_semester', $semester, null, ['class' => 'form-control '.($errors->has('id_semester') ? 'is-invalid' : ''), 'id' => 'id_semester']) !!}
            @error('id_semester')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="form-group col-lg-6">
            <label for="judul">Judul</label>
            {!! Form::text('judul', null, ['class' => 'form-control '.($errors->has('judul') ? 'is-invalid' : ''), 'id' => 'judul']) !!}
            @error('judul')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>

    {{-- <div class="row">
        <div class="form-group col-lg-6">
            <label for="keterangan">Keterangan</label>
            {!! Form::text('keterangan', null, ['class' => 'form-control '.($errors->has('keterangan') ? 'is-invalid' : ''), 'id' => 'keterangan']) !!}
            @error('keterangan')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group col-lg-6">
            <label for="lokasi">Lokasi</label>
            {!! Form::text('lokasi', null, ['class' => 'form-control '.($errors->has('lokasi') ? 'is-invalid' : ''), 'id' => 'lokasi']) !!}
            @error('lokasi')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>

    <div class="row">
        <div class="form-group col-lg-6">
            <label for="sk_tugas">SK Tugas</label>
            {!! Form::text('sk_tugas', null, ['class' => 'form-control '.($errors->has('sk_tugas') ? 'is-invalid' : ''), 'id' => 'sk_tugas']) !!}
            @error('sk_tugas')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div> --}}

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
            
            var id_jenis_aktivitas = $(this).data('id_jenis_aktivitas');
            var id_prodi = $(this).data('id_prodi');
            var id_semester = $(this).data('id_semester');
            var judul = $(this).data('judul');
            var keterangan = $(this).data('keterangan');
            var lokasi = $(this).data('lokasi');
            var sk_tugas = $(this).data('sk_tugas');

            $('[name=id_jenis_aktivitas]').val(id_jenis_aktivitas);
            $('[name=id_prodi]').val(id_prodi);
            $('[name=id_semester]').val(id_semester);
            $('[name=judul]').val(judul);
            $('[name=keterangan]').val(keterangan);
            $('[name=lokasi]').val(lokasi);
            $('[name=sk_tugas]').val(sk_tugas);
        });
    </script>
@endpush