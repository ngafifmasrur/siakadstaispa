@extends('layouts.app')
@section('title', 'Kurikulum Prodi')

@section('content')
<x-header>
    Kurikulum Prodi
</x-header>

<x-card>
    <div class="row">
        <div class="form-group col-lg-3">
            <label for="prodi" class="font-weight-bold">Program Studi</label>
            {!! Form::select('prodi', $prodi, null, ['class' => 'form-control', 'id' => 'prodi', 'data-targt' => '#id_matkul']) !!}
        </div>
        <div class="form-group col-lg-3">
            <label for="tahun_ajaran" class="font-weight-bold">Tahun Pelajaran</label>
            {!! Form::select('tahun_ajaran', $tahun_ajaran, null, ['class' => 'form-control', 'id' => 'tahun_ajaran']) !!}
        </div>
    </div>
</x-card>

<x-card>
    <form action="{{ route('admin.kurikulum_prodi.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="form-group col-lg-3">
                <label for="id_matkul" class="font-weight-bold">Mata Kuliah</label>
                {!! Form::select('id_matkul', [], null, ['class' => 'form-control '.($errors->has('id_matkul') ? 'is-invalid' : ''), 'id' => 'id_matkul']) !!}
                @error('id_matkul')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group col-lg-2">
                <label for="id_semester" class="font-weight-bold">Semester</label>
                {!! Form::select('id_semester', [], null, ['class' => 'form-control '.($errors->has('id_semester') ? 'is-invalid' : ''), 'id' => 'id_semester']) !!}
                @error('id_semester')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group col-lg-2">
                <label for="nilai_minimum" class="font-weight-bold">Nilai Min</label>
                {!! Form::select('nilai_minimum', ['' => 'Pilih Nilai Min', 'A' => 'A', 'B' => 'B', 'C' => 'C', 'D' => 'D', 'E' => 'E'], null, ['class' => 'form-control '.($errors->has('nilai_minimum') ? 'is-invalid' : ''), 'id' => 'nilai_minimum']) !!}
                @error('nilai_minimum')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group col-lg-2">
                <label for="opsi" class="font-weight-bold d-block">Opsi Tambahan</label>
                <div class="form-check form-check-inline">
                    {!! Form::checkbox('mk_wajib', 1, 1,['class' => 'form-check-input', 'id' => 'mk_wajib']) !!}
                    <label class="form-check-label" for="mk_wajib">
                    MK Wajib
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    {!! Form::checkbox('mk_paket', 1, 1,['class' => 'form-check-input', 'id' => 'mk_paket']) !!}
                    <label class="form-check-label" for="mk_paket">
                    MK Paket
                    </label>
                </div>
            </div>
            <div class="form-group col-lg-2 my-auto">
                <button class="btn btn-app btn-sm btn-primary" type="submit"><i class="fa fa-plus mr-2"></i>Tambah</button>
            </div>
        </div>
    </form>
</x-card>

<div class="row">
    @foreach ($table_semester as $item)
            <div class="col-lg-6">
                <x-slot name="title">Semester {{ $item }}</x-slot>
                <x-semester-table
                    :title="'Semester '.$item"
                    :id="'semester'.$item"
                    :route="route('admin.kurikulum_prodi.data_index', ['tahun_ajaran' => request()->get('tahun_ajaran')])" 
                    :table="[
                        ['title' => 'No.', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => 'false', 'searchable' => 'false', 'width' => '10'],
                        ['title' => 'Nama Mata Kuliah', 'data' => 'nama_matkul', 'name' => 'nama_matkul', 'classname' => 'text-left'],
                        ['title' => 'SKS', 'data' => 'sks', 'name' => 'sks'],
                        ['title' => 'Aksi', 'data' => 'action', 'orderable' => 'false', 'searchable' => 'false'],
                    ]"
                />
            </div>
    @endforeach
</div>

<x-modal.delete/>

<x-modal class="edit-form" id="modal-form">
    <x-slot name="title">Mata Kuliah Aktif</x-slot>
    <x-slot name="modalPosition">modal-dialog-centered</x-slot>
    @csrf
    @method('put')
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="id_matkul">Mata Kuliah</label>
            {!! Form::select('id_matkul', $matkul, null, ['class' => 'form-control '.($errors->has('id_matkul') ? 'is-invalid' : ''), 'id' => 'id_matkul']) !!}
            @error('id_matkul')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <div class="form-group col-lg-12">
            <label for="id_semester">Semester</label>
            {!! Form::select('id_semester', $semester, null, ['class' => 'form-control '.($errors->has('id_semester') ? 'is-invalid' : ''), 'id' => 'id_semester']) !!}
            @error('id_semester')
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
        var prodi = $('#prodi').val();
        var tahun_ajaran = $('#tahun_ajaran').val();



        $(document).on('click', '.btn_edit', function () {
            $('.modal-form').modal('show');
            // $('.modal-form form')[0].reset();
            $('.modal-form form').attr('action',  $(this).data('route'));
            $('[name=_method]').val('put');
            // var id_matkul = $(this).data('id_matkul');
            // var id_semester = $(this).data('id_semester');

            // $('[name=id_semester]').val(id_semester);
            // $('[name=id_matkul]').val(id_matkul);

        });



        $(function () {
            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            });

            $('#prodi').on('change', function () {
                $.ajax({
                    url: '{{ route('mata_kuliah_list') }}',
                    method: 'POST',
                    data: {id_prodi: $(this).val()},
                    success: function (response) {
                        $('#id_matkul').empty();

                        // $.each(response, function (id, name) {
                        //     $('#id_matkul').append(new Option(name, id))
                        // })
                        $('#id_matkul').append($('<option>', {
                            value: '',
                            text:  "Pilih Mata Kuliah"
                        }));
                        $.each(response.data,function(index,row){
                            $('#id_matkul').append($('<option>', {
                                value: row.id_matkul,
                                text:  row.nama_mata_kuliah
                            }));
                        });
                        $("#id_matkul").selectpicker("refresh");

                    }
                })
            });
        });

        
        $(function () {
            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            });

            $('#tahun_ajaran').on('change', function () {
                $.ajax({
                    url: '{{ route('semester_list') }}',
                    method: 'POST',
                    data: {id_tahun_ajaran: $(this).val()},
                    success: function (response) {
                        $('#id_semester').empty();

                        // $.each(response, function (id, name) {
                        //     $('#id_matkul').append(new Option(name, id))
                        // })
                        $('#id_semester').append($('<option>', {
                            value: '',
                            text:  "Pilih Semester"
                        }));
                        $.each(response.data,function(index,row){
                            $('#id_semester').append($('<option>', {
                                value: row.id_semester,
                                text:  row.nama_semester
                            }));
                        });
                        $("#id_semester").selectpicker("refresh");

                    }
                })
            });
        });
    </script>
@endpush