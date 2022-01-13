@extends('layouts.app')
@section('title', 'Mata Kuliah')

@section('content')

<x-header>
    Mata Kuliah
</x-header>

<x-card>
    <div class="row">
        <div class="form-group col-lg-3">
            <label for="prodi">Program Studi</label>
            {!! Form::select('prodi', $prodi, null, ['class' => 'form-control', 'id' => 'prodi']) !!}
        </div>
    </div>
</x-card>

<x-card-table>
    <x-slot name="title">Data Mata Kuliah</x-slot>
    <x-slot name="button">
        <a class="btn btn-app btn-sm btn-primary add-form" data-url="{{ route('admin.mata_kuliah.store') }}" href="#"><i class="fa fa-plus mr-2"></i>Tambah</a>
    </x-slot>
    
    <x-datatable 
    :route="route('admin.mata_kuliah.data_index')" 
    :table="[
        ['title' => 'No.', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => 'false', 'searchable' => 'false', 'width' => '10'],
        ['title' => 'Kode', 'data' => 'kode_mata_kuliah', 'name' => 'kode_mata_kuliah', 'width' => '10'],
        ['title' => 'Nama Mata Kuliah', 'data' => 'nama_mata_kuliah', 'name' => 'nama_mata_kuliah', 'classname' => 'text-left'],
        ['title' => 'Program Studi', 'data' => 'prodi', 'name' => 'prodi', 'classname' => 'text-left'],
        ['title' => 'Jenis', 'data' => 'jenis', 'name' => 'jenis'],
        ['title' => 'Kelompok', 'data' => 'kelompok', 'name' => 'kelompok'],
        ['title' => 'SKS MK', 'data' => 'sks_mata_kuliah', 'name' => 'sks_mata_kuliah'],
        ['title' => 'SKS TM', 'data' => 'sks_tatap_muka', 'name' => 'sks_tatap_muka'],
        ['title' => 'SKS P', 'data' => 'sks_praktek', 'name' => 'sks_praktek'],
        ['title' => 'SKS PL', 'data' => 'sks_praktek_lapangan', 'name' => 'sks_praktek_lapangan'],
        ['title' => 'Aksi', 'data' => 'action', 'orderable' => 'false', 'searchable' => 'false'],
    ]"
    :filter="[
        ['data' => '_token', 'value' => 'token'],
        ['data' => 'prodi', 'value' => 'prodi'],
    ]"
    />
</x-card-table>

<x-modal.delete/>

<x-modal class="modal-form" id="modal-form">
    <x-slot name="title">Mata Kuliah</x-slot>
    <x-slot name="modalPosition">modal-dialog-centered</x-slot>
    
    @csrf 
    @method('post')
    <div class="row">
        <div class="form-group col-lg-12">
            <label for="id_prodi">Program Studi</label>
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
            <label for="kode_mata_kuliah">Kode Mata Kuliah</label>
            {!! Form::text('kode_mata_kuliah', null, ['class' => 'form-control '.($errors->has('kode_mata_kuliah') ? 'is-invalid' : ''), 'id' => 'kode_mata_kuliah']) !!}
            @error('kode_mata_kuliah')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group col-lg-6">
            <label for="nama_mata_kuliah">Nama Mata Kuliah</label>
            {!! Form::text('nama_mata_kuliah', null, ['class' => 'form-control '.($errors->has('nama_mata_kuliah') ? 'is-invalid' : ''), 'id' => 'nama_mata_kuliah']) !!}
            @error('nama_mata_kuliah')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="row">
        <div class="form-group col-lg-6">
            <label for="id_jenis_mata_kuliah">Jenis</label>
            {!! Form::select('id_jenis_mata_kuliah', $jenis_matkul, null, ['class' => 'form-control '.($errors->has('id_jenis_mata_kuliah') ? 'is-invalid' : ''), 'id' => 'id_jenis_mata_kuliah']) !!}
            @error('id_jenis_mata_kuliah')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group col-lg-6">
            <label for="id_kelompok_mata_kuliah">Kelompok</label>
            {!! Form::select('id_kelompok_mata_kuliah', $kelompok_matkul, null, ['class' => 'form-control '.($errors->has('id_kelompok_mata_kuliah') ? 'is-invalid' : ''), 'id' => 'id_kelompok_mata_kuliah']) !!}
            @error('id_kelompok_mata_kuliah')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
        </div>
    </div>
    <div class="row">
        <div class="form-group col-lg-6">
            <label for="sks_mata_kuliah">SKS</label>
            {!! Form::number('sks_mata_kuliah', null, ['class' => 'form-control '.($errors->has('sks_mata_kuliah') ? 'is-invalid' : ''), 'id' => 'sks_mata_kuliah']) !!}
            @error('sks_mata_kuliah')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="form-group col-lg-6">
            <label for="sks_tatap_muka">SKS Tatap Muka</label>
            {!! Form::number('sks_tatap_muka', null, ['class' => 'form-control '.($errors->has('sks_tatap_muka') ? 'is-invalid' : ''), 'id' => 'sks_tatap_muka']) !!}
            @error('sks_tatap_muka')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
    </div>
    <div class="row">
        <div class="form-group col-lg-6">
            <label for="sks_mata_kuliah">SKS Praktek</label>
            {!! Form::number('sks_praktek', null, ['class' => 'form-control '.($errors->has('sks_praktek') ? 'is-invalid' : ''), 'id' => 'sks_praktek']) !!}
            @error('sks_praktek')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="form-group col-lg-6">
            <label for="sks_praktek_lapangan">SKS Praktek Lapangan</label>
            {!! Form::number('sks_praktek_lapangan', null, ['class' => 'form-control '.($errors->has('sks_praktek_lapangan') ? 'is-invalid' : ''), 'id' => 'sks_praktek_lapangan']) !!}
            @error('sks_praktek_lapangan')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
    </div>
    <div class="row">
        <div class="form-group col-lg-6">
            <label for="sks_simulasi">SKS Simulasi</label>
            {!! Form::number('sks_simulasi', null, ['class' => 'form-control '.($errors->has('sks_simulasi') ? 'is-invalid' : ''), 'id' => 'sks_simulasi']) !!}
            @error('sks_simulasi')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="form-group col-lg-6">
            <label for="metode_kuliah">Metode Kuliah</label>
            {!! Form::text('metode_kuliah', null, ['class' => 'form-control '.($errors->has('metode_kuliah') ? 'is-invalid' : ''), 'id' => 'metode_kuliah']) !!}
            @error('metode_kuliah')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
    </div>

    <div class="row">
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
            <label for="tanggal_selesai_efektif">Tanggal Selesai Efektif</label>
            {!! Form::date('tanggal_selesai_efektif', null, ['class' => 'form-control '.($errors->has('tanggal_selesai_efektif') ? 'is-invalid' : ''), 'id' => 'tanggal_selesai_efektif']) !!}
            @error('tanggal_selesai_efektif')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
    </div>

    @php
        $ya_tidak = [
            '1' => 'Ya',
            '0' => 'Tidak'
        ];
    @endphp
    <div class="row">
        <div class="form-group col-lg-6">
            <label for="ada_sap">Ada SAP</label>
            {!! Form::select('ada_sap', $ya_tidak, null, ['class' => 'form-control '.($errors->has('nama_depan') ? 'is-invalid' : ''), 'id' => 'ada_sap']) !!}
        </div>
        <div class="form-group col-lg-6">
            <label for="ada_silabus">Ada Silabus</label>
            {!! Form::select('ada_silabus', $ya_tidak, null, ['class' => 'form-control '.($errors->has('nama_depan') ? 'is-invalid' : ''), 'id' => 'ada_silabus']) !!}
        </div>
    </div>
    <div class="row">
        <div class="form-group col-lg-6">
            <label for="ada_bahan_ajar">Ada Bahan Ajar</label>
            {!! Form::select('ada_bahan_ajar', $ya_tidak, null, ['class' => 'form-control '.($errors->has('nama_depan') ? 'is-invalid' : ''), 'id' => 'ada_bahan_ajar']) !!}
        </div>
        <div class="form-group col-lg-6">
            <label for="ada_acara_praktek">Ada Acara Praktek</label>
            {!! Form::select('ada_acara_praktek', $ya_tidak, null, ['class' => 'form-control '.($errors->has('nama_depan') ? 'is-invalid' : ''), 'id' => 'ada_acara_praktek']) !!}
        </div>
    </div>
    <div class="row">
        <div class="form-group col-lg-6">
            <label for="ada_diktat">Ada Diktat</label>
            {!! Form::select('ada_diktat', $ya_tidak, null, ['class' => 'form-control '.($errors->has('nama_depan') ? 'is-invalid' : ''), 'id' => 'ada_diktat']) !!}
        </div>
        <div class="form-group col-lg-6">
            <label for="paket">Paket</label>
            {!! Form::select('paket', $ya_tidak, null, ['class' => 'form-control '.($errors->has('nama_depan') ? 'is-invalid' : ''), 'id' => 'paket']) !!}
        </div>
    </div>
    <x-slot name="footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </x-slot>
</x-modal>

<x-modal class="edit-form" id="modal-form">
    <x-slot name="title">Mata Kuliah</x-slot>
    <x-slot name="modalPosition">modal-dialog-centered</x-slot>
    @csrf
    @method('put')
    <div class="row">
        <div class="form-group col-lg-12">
            <label for="id_prodi">Program Studi</label>
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
            <label for="kode_mata_kuliah">Kode Mata Kuliah</label>
            {!! Form::text('kode_mata_kuliah', null, ['class' => 'form-control '.($errors->has('kode_mata_kuliah') ? 'is-invalid' : ''), 'id' => 'kode_mata_kuliah']) !!}
            @error('kode_mata_kuliah')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group col-lg-6">
            <label for="nama_mata_kuliah">Nama Mata Kuliah</label>
            {!! Form::text('nama_mata_kuliah', null, ['class' => 'form-control '.($errors->has('nama_mata_kuliah') ? 'is-invalid' : ''), 'id' => 'nama_mata_kuliah']) !!}
            @error('nama_mata_kuliah')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="row">
        <div class="form-group col-lg-6">
            <label for="id_jenis_mata_kuliah">Jenis</label>
            {!! Form::select('id_jenis_mata_kuliah', $jenis_matkul, null, ['class' => 'form-control '.($errors->has('id_jenis_mata_kuliah') ? 'is-invalid' : ''), 'id' => 'id_jenis_mata_kuliah']) !!}
            @error('id_jenis_mata_kuliah')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group col-lg-6">
            <label for="id_kelompok_mata_kuliah">Kelompok</label>
            {!! Form::select('id_kelompok_mata_kuliah', $kelompok_matkul, null, ['class' => 'form-control '.($errors->has('id_kelompok_mata_kuliah') ? 'is-invalid' : ''), 'id' => 'id_kelompok_mata_kuliah']) !!}
            @error('id_kelompok_mata_kuliah')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
        </div>
    </div>
    <div class="row">
        <div class="form-group col-lg-6">
            <label for="sks_mata_kuliah">SKS</label>
            {!! Form::number('sks_mata_kuliah', null, ['class' => 'form-control '.($errors->has('sks_mata_kuliah') ? 'is-invalid' : ''), 'id' => 'sks_mata_kuliah']) !!}
            @error('sks_mata_kuliah')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="form-group col-lg-6">
            <label for="sks_tatap_muka">SKS Tatap Muka</label>
            {!! Form::number('sks_tatap_muka', null, ['class' => 'form-control '.($errors->has('sks_tatap_muka') ? 'is-invalid' : ''), 'id' => 'sks_tatap_muka']) !!}
            @error('sks_tatap_muka')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
    </div>
    <div class="row">
        <div class="form-group col-lg-6">
            <label for="sks_mata_kuliah">SKS Praktek</label>
            {!! Form::number('sks_praktek', null, ['class' => 'form-control '.($errors->has('sks_praktek') ? 'is-invalid' : ''), 'id' => 'sks_praktek']) !!}
            @error('sks_praktek')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="form-group col-lg-6">
            <label for="sks_praktek_lapangan">SKS Praktek Lapangan</label>
            {!! Form::number('sks_praktek_lapangan', null, ['class' => 'form-control '.($errors->has('sks_praktek_lapangan') ? 'is-invalid' : ''), 'id' => 'sks_praktek_lapangan']) !!}
            @error('sks_praktek_lapangan')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
    </div>
    <div class="row">
        <div class="form-group col-lg-6">
            <label for="sks_simulasi">SKS Simulasi</label>
            {!! Form::number('sks_simulasi', null, ['class' => 'form-control '.($errors->has('sks_simulasi') ? 'is-invalid' : ''), 'id' => 'sks_simulasi']) !!}
            @error('sks_simulasi')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="form-group col-lg-6">
            <label for="metode_kuliah">Metode Kuliah</label>
            {!! Form::text('metode_kuliah', null, ['class' => 'form-control '.($errors->has('metode_kuliah') ? 'is-invalid' : ''), 'id' => 'metode_kuliah']) !!}
            @error('metode_kuliah')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
    </div>

    <div class="row">
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
            <label for="tanggal_selesai_efektif">Tanggal Selesai Efektif</label>
            {!! Form::date('tanggal_selesai_efektif', null, ['class' => 'form-control '.($errors->has('tanggal_selesai_efektif') ? 'is-invalid' : ''), 'id' => 'tanggal_selesai_efektif']) !!}
            @error('tanggal_selesai_efektif')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
    </div>

    @php
        $ya_tidak = [
            '1' => 'Ya',
            '0' => 'Tidak'
        ];
    @endphp
    <div class="row">
        <div class="form-group col-lg-6">
            <label for="ada_sap">Ada SAP</label>
            {!! Form::select('ada_sap', $ya_tidak, null, ['class' => 'form-control '.($errors->has('nama_depan') ? 'is-invalid' : ''), 'id' => 'ada_sap']) !!}
        </div>
        <div class="form-group col-lg-6">
            <label for="ada_silabus">Ada Silabus</label>
            {!! Form::select('ada_silabus', $ya_tidak, null, ['class' => 'form-control '.($errors->has('nama_depan') ? 'is-invalid' : ''), 'id' => 'ada_silabus']) !!}
        </div>
    </div>
    <div class="row">
        <div class="form-group col-lg-6">
            <label for="ada_bahan_ajar">Ada Bahan Ajar</label>
            {!! Form::select('ada_bahan_ajar', $ya_tidak, null, ['class' => 'form-control '.($errors->has('nama_depan') ? 'is-invalid' : ''), 'id' => 'ada_bahan_ajar']) !!}
        </div>
        <div class="form-group col-lg-6">
            <label for="ada_acara_praktek">Ada Acara Praktek</label>
            {!! Form::select('ada_acara_praktek', $ya_tidak, null, ['class' => 'form-control '.($errors->has('nama_depan') ? 'is-invalid' : ''), 'id' => 'ada_acara_praktek']) !!}
        </div>
    </div>
    <div class="row">
        <div class="form-group col-lg-6">
            <label for="ada_diktat">Ada Diktat</label>
            {!! Form::select('ada_diktat', $ya_tidak, null, ['class' => 'form-control '.($errors->has('nama_depan') ? 'is-invalid' : ''), 'id' => 'ada_diktat']) !!}
        </div>
        <div class="form-group col-lg-6">
            <label for="paket">Paket</label>
            {!! Form::select('paket', $ya_tidak, null, ['class' => 'form-control '.($errors->has('nama_depan') ? 'is-invalid' : ''), 'id' => 'paket']) !!}
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
        var token = '{{ csrf_token() }}';
        var prodi = $('#prodi').val();

        // $(document).on('change','#prodi',function(){
        //     $('#dataTables').DataTable().ajax.reload();
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
            var id_prodi = $(this).data('id_prodi');
            var kode_mata_kuliah = $(this).data('kode_mata_kuliah');
            var nama_mata_kuliah = $(this).data('nama_mata_kuliah');
            var id_jenis_mata_kuliah = $(this).data('id_jenis_mata_kuliah');
            var id_kelompok_mata_kuliah = $(this).data('id_kelompok_mata_kuliah');
            var sks_mata_kuliah = $(this).data('sks_mata_kuliah');
            var sks_tatap_muka = $(this).data('sks_tatap_muka');
            var sks_praktek = $(this).data('sks_praktek');
            var sks_praktek_lapangan = $(this).data('sks_praktek_lapangan');
            var sks_simulasi = $(this).data('sks_simulasi');
            var metode_kuliah = $(this).data('metode_kuliah');
            var ada_sap = $(this).data('ada_sap');
            var ada_silabus = $(this).data('ada_silabus');
            var ada_bahan_ajar = $(this).data('ada_bahan_ajar');
            var ada_acara_praktek = $(this).data('ada_acara_praktek');
            var ada_diktat = $(this).data('ada_diktat');
            var paket = $(this).data('paket');
            var tanggal_mulai_efektif = $(this).data('tanggal_mulai_efektif');
            var tanggal_selesai_efektif = $(this).data('tanggal_selesai_efektif');

            $('[name=id_prodi]').val(id_prodi);
            $('[name=kode_mata_kuliah]').val(kode_mata_kuliah);
            $('[name=nama_mata_kuliah]').val(nama_mata_kuliah);
            $('[name=id_jenis_mata_kuliah]').val(id_jenis_mata_kuliah);
            $('[name=id_kelompok_mata_kuliah]').val(id_kelompok_mata_kuliah);
            $('[name=sks_mata_kuliah]').val(sks_mata_kuliah);
            $('[name=sks_tatap_muka]').val(sks_tatap_muka);
            $('[name=sks_praktek]').val(sks_praktek);
            $('[name=sks_praktek_lapangan]').val(sks_praktek_lapangan);
            $('[name=sks_simulasi]').val(sks_simulasi);
            $('[name=metode_kuliah]').val(metode_kuliah);
            $('[name=jumlah_sks_pilihan]').val(jumlah_sks_pilihan);            
            $('[name=id_semester]').val(id_semester);
            $('[name=ada_sap]').val(ada_sap);
            $('[name=ada_silabus]').val(ada_silabus);
            $('[name=ada_bahan_ajar]').val(ada_bahan_ajar);
            $('[name=ada_acara_praktek]').val(ada_acara_praktek);
            $('[name=ada_diktat]').val(ada_diktat);            
            $('[name=id_semester]').val(id_semester);
            $('[name=paket]').val(paket);
            $('[name=tanggal_mulai_efektif]').val(tanggal_mulai_efektif);
            $('[name=tanggal_selesai_efektif]').val(tanggal_selesai_efektif);

        });
    </script>
@endpush