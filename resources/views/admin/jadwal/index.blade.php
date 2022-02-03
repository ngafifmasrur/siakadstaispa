@extends('layouts.app')
@section('title', 'Jadwal')

@section('content')
<x-header>
    Jadwal Kuliah
</x-header>

<x-card>
    <div class="row">
        <div class="form-group col-lg-3">
            <label for="ruangan">Ruangan</label>
            {!! Form::select('ruangan', $ruangan, null, ['class' => 'form-control', 'id' => 'ruangan']) !!}
        </div>
        <div class="form-group col-lg-3">
            <label for="dosen">Dosen</label>
            {!! Form::select('dosen', $dosen, null, ['class' => 'form-control', 'id' => 'dosen']) !!}
        </div>
    </div>
</x-card>

<x-card-table>
    <x-slot name="title">Data Jadwal Kuliah</x-slot>
    <x-slot name="button">
        <a class="btn btn-app btn-sm btn-primary add-form" data-url="{{ route('admin.jadwal.store') }}" href="#"><i class="fa fa-plus mr-2"></i>Tambah</a>
    </x-slot>
    
    <x-datatable 
    :route="route('admin.jadwal.data_index')" 
    :table="[
        ['title' => 'No.', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => 'false', 'searchable' => 'false', 'width' => '10'],
        ['title' => 'Ruangan', 'data' => 'ruangan', 'name' => 'ruangan', 'classname' => 'text-left'],
        ['title' => 'Dosen', 'data' => 'dosen', 'name' => 'dosen', 'classname' => 'text-left'],
        ['title' => 'Kelas', 'data' => 'kelas', 'name' => 'kelas', 'classname' => 'text-left'],
        ['title' => 'Hari', 'data' => 'hari', 'name' => 'hari', 'classname' => 'text-left'],
        ['title' => 'Jam Mulai', 'data' => 'jam_mulai', 'name' => 'jam_mulai'],
        ['title' => 'Jam Akhir', 'data' => 'jam_akhir', 'name' => 'jam_akhir'],
        ['title' => 'Aksi', 'data' => 'action', 'orderable' => 'false', 'searchable' => 'false'],
    ]"
    :filter="[
        ['data' => 'id_ruang', 'value' => '$(`#ruangan`).val()'],
        ['data' => 'id_dosen', 'value' => '$(`#dosen`).val()'],
    ]"
    />
</x-card-table>

<x-modal.delete/>

<x-modal class="modal-form" id="modal-form">
    <x-slot name="title">Jadwal</x-slot>
    <x-slot name="modalPosition">modal-dialog-centered</x-slot>
    
    @csrf 
    @method('post')
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="id_dosen">Dosen</label>
            {!! Form::select('id_dosen', $dosen, null, ['class' => 'form-control '.($errors->has('id_dosen') ? 'is-invalid' : ''), 'id' => 'id_dosen']) !!}
            @error('id_dosen')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="id_kelas_kuliah">Kelas</label>
            {!! Form::select('id_kelas_kuliah', $kelas, null, ['class' => 'form-control '.($errors->has('id_kelas_kuliah') ? 'is-invalid' : ''), 'id' => 'id_kelas_kuliah']) !!}
            @error('id_kelas_kuliah')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="id_ruang">Ruangan</label>
            {!! Form::select('id_ruang', $ruangan, null, ['class' => 'form-control '.($errors->has('id_ruang') ? 'is-invalid' : ''), 'id' => 'id_ruang']) !!}
            @error('id_ruang')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    @php
        $hari = [
            'Senin' => 'Senin',
            'Selasa' => 'Selasa',
            'Rabu' => 'Rabu',
            'Kamis' => 'Kamis',
            'Jumat' => 'Jumat',
            'Sabtu' => 'Sabtu',
            'Minggu' => 'Minggu',
        ];
    @endphp
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
        <div class="form-group col-lg-12">
            <label for="jam_mulai">Jam Mulai</label>
            {!! Form::time('jam_mulai',null, ['class' => 'form-control '.($errors->has('jam_mulai') ? 'is-invalid' : ''), 'id' => 'jam_mulai']) !!}
            @error('jam_mulai')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="jam_akhir">Jam Akhir</label>
            {!! Form::time('jam_akhir',null, ['class' => 'form-control '.($errors->has('jam_akhir') ? 'is-invalid' : ''), 'id' => 'jam_akhir']) !!}
            @error('jam_akhir')
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
    <x-slot name="title">Jadwal</x-slot>
    <x-slot name="modalPosition">modal-dialog-centered</x-slot>
    @csrf
    @method('put')
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="id_dosen">Dosen</label>
            {!! Form::select('id_dosen', $dosen, null, ['class' => 'form-control '.($errors->has('id_dosen') ? 'is-invalid' : ''), 'id' => 'id_dosen']) !!}
            @error('id_dosen')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="id_kelas_kuliah">Kelas</label>
            {!! Form::select('id_kelas_kuliah', $kelas, null, ['class' => 'form-control '.($errors->has('id_kelas_kuliah') ? 'is-invalid' : ''), 'id' => 'id_kelas_kuliah']) !!}
            @error('id_kelas_kuliah')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="id_ruang">Ruangan</label>
            {!! Form::select('id_ruang', $ruangan, null, ['class' => 'form-control '.($errors->has('id_ruang') ? 'is-invalid' : ''), 'id' => 'id_ruang']) !!}
            @error('id_ruang')
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
        <div class="form-group col-lg-12">
            <label for="jam_mulai">Jam Mulai</label>
            {!! Form::time('jam_mulai',null, ['class' => 'form-control '.($errors->has('jam_mulai') ? 'is-invalid' : ''), 'id' => 'jam_mulai']) !!}
            @error('jam_mulai')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="jam_akhir">Jam Akhir</label>
            {!! Form::time('jam_akhir',null, ['class' => 'form-control '.($errors->has('jam_akhir') ? 'is-invalid' : ''), 'id' => 'jam_akhir']) !!}
            @error('jam_akhir')
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

        $( document ).ready(function() {
            $(document).on('change','#prodi, #semester, #tahun_ajaran',function(){
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
            var id_kelas_kuliah = $(this).data('id_kelas_kuliah');
            var id_ruang = $(this).data('id_ruang');
            var hari = $(this).data('hari');
            var jam_mulai = $(this).data('jam_mulai');
            var jam_akhir = $(this).data('jam_akhir');

            $('[name=id_dosen]').val(id_dosen);
            $('[name=id_kelas_kuliah]').val(id_kelas_kuliah);
            $('[name=id_ruang]').val(id_ruang);
            $('[name=hari]').val(hari);
            $('[name=jam_mulai]').val(jam_mulai);
            $('[name=jam_akhir]').val(jam_akhir);

        });
    </script>
@endpush