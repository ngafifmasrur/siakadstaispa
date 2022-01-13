@extends('layouts.app')
@section('title', 'Semester Mahasiswa')

@section('content')

<x-header>
    Semester Mahasiswa
</x-header>

<x-card>
    <div class="row">
        <div class="form-group col-lg-3">
            <label for="prodi">Program Studi</label>
            {!! Form::select('prodi', $prodi, null, ['class' => 'form-control', 'id' => 'prodi']) !!}
        </div>
        <div class="form-group col-lg-3">
            <label for="tahun_ajaran">Tahun Ajaran</label>
            {!! Form::select('tahun_ajaran', $tahun_ajaran, null, ['class' => 'form-control', 'id' => 'tahun_ajaran']) !!}
        </div>
        <div class="form-group col-lg-3">
            <label for="semester">Semester</label>
            {!! Form::select('semester', $semester, null, ['class' => 'form-control', 'id' => 'semester']) !!}
        </div>
    </div>
</x-card>

<x-card-table>
    <x-slot name="title">Data Semester Mahasiswa</x-slot>
    <x-slot name="button">
        <a class="btn btn-app btn-sm btn-primary add-form" data-url="{{ route('admin.semester_mahasiswa.store') }}" href="#"><i class="fa fa-plus mr-2"></i>Tambah</a>
    </x-slot>

    <x-datatable 
    :route="route('admin.semester_mahasiswa.data_index')" 
    :table="[
        ['title' => 'No.', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => 'false', 'searchable' => 'false', 'width' => '10'],  
        ['title' => 'Nama Mahasiswa', 'data' => 'mahasiswa', 'name' => 'mahasiswa', 'classname' => 'text-left'], 
        ['title' => 'Tahun Ajaran', 'data' => 'tahun_ajaran', 'name' => 'tahun_ajaran'],                         
        ['title' => 'Semester', 'data' => 'semester', 'name' => 'semester'],              
        ['title' => 'Program Studi', 'data' => 'prodi', 'name' => 'prodi', 'classname' => 'text-left'],                         
        ['title' => 'Status', 'data' => 'status', 'name' => 'status'],
        ['title' => 'Aksi', 'data' => 'action', 'orderable' => 'false', 'searchable' => 'false'],
    ]"
    :filter="[
        ['data' => '_token', 'value' => 'token'],
        ['data' => 'prodi', 'value' => 'prodi'],
        ['data' => 'tahun_ajaran', 'value' => 'tahun_ajaran'],
        ['data' => 'semester', 'value' => 'semester'],
    ]"
    />

</x-card-table>

<x-modal.delete/>

<x-modal class="modal-form" id="modal-form">
    <x-slot name="title">Semester Mahasiswa</x-slot>
    <x-slot name="modalPosition">modal-dialog-centered</x-slot>
    
    @csrf 
    @method('post')
    <div class="row">
        <div class="form-group col-lg-6">
            <label for="id_mahasiswa">Mahasiswa</label>
            {!! Form::select('id_mahasiswa', $mahasiswa, NULL, ['class' => 'form-control '.($errors->has('id_mahasiswa') ? 'is-invalid' : ''), 'id' => 'id_mahasiswa']) !!}
            @error('id_mahasiswa')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group col-lg-6">
            <label for="id_prodi">Program Studi</label>
            {!! Form::select('id_prodi', $prodi, NULL, ['class' => 'form-control '.($errors->has('id_prodi') ? 'is-invalid' : ''), 'id' => 'id_prodi']) !!}
            @error('id_prodi')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>  
    <div class="row">
        <div class="form-group col-lg-6">
            <label for="id_tahun_ajaran">Tahun Ajaran</label>
            {!! Form::select('id_tahun_ajaran', $tahun_ajaran, NULL, ['class' => 'form-control '.($errors->has('id_tahun_ajaran') ? 'is-invalid' : ''), 'id' => 'id_tahun_ajaran']) !!}
            @error('id_tahun_ajaran')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group col-lg-6">
            <label for="id_semester">Semester</label>
            {!! Form::select('id_semester', $semester, null, ['class' => 'form-control '.($errors->has('id_semester') ? 'is-invalid' : ''), 'id' => 'id_semester']) !!}
            @error('id_semester')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div> 
    <div class="row">
        <div class="form-group col-lg-6">
            <label for="status">Status</label>
            {!! Form::select('status', [ 'Aktif' => 'Aktif', 'Tidak Aktif' => 'Tidak Aktif'], null, ['class' => 'form-control '.($errors->has('status') ? 'is-invalid' : ''), 'id' => 'status']) !!}
            @error('status')
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
    <x-slot name="title">Semester Mahasiswa</x-slot>
    <x-slot name="modalPosition">modal-dialog-centered</x-slot>
    @csrf
    @method('put')
    <div class="row">
        <div class="form-group col-lg-6">
            <label for="id_mahasiswa">Mahasiswa</label>
            {!! Form::select('id_mahasiswa', $mahasiswa, NULL, ['class' => 'form-control '.($errors->has('id_mahasiswa') ? 'is-invalid' : ''), 'id' => 'id_mahasiswa']) !!}
            @error('id_mahasiswa')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group col-lg-6">
            <label for="id_prodi">Program Studi</label>
            {!! Form::select('id_prodi', $prodi, NULL, ['class' => 'form-control '.($errors->has('id_prodi') ? 'is-invalid' : ''), 'id' => 'id_prodi']) !!}
            @error('id_prodi')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>  
    <div class="row">
        <div class="form-group col-lg-6">
            <label for="id_tahun_ajaran">Tahun Ajaran</label>
            {!! Form::select('id_tahun_ajaran', $tahun_ajaran, NULL, ['class' => 'form-control '.($errors->has('id_tahun_ajaran') ? 'is-invalid' : ''), 'id' => 'id_tahun_ajaran']) !!}
            @error('id_tahun_ajaran')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group col-lg-6">
            <label for="id_semester">Semester</label>
            {!! Form::select('id_semester', $semester, null, ['class' => 'form-control '.($errors->has('id_semester') ? 'is-invalid' : ''), 'id' => 'id_semester']) !!}
            @error('id_semester')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div> 
    <div class="row">
        <div class="form-group col-lg-6">
            <label for="status">Status</label>
            {!! Form::select('status', [ 'Aktif' => 'Aktif', 'Tidak Aktif' => 'Tidak Aktif'], null, ['class' => 'form-control '.($errors->has('status') ? 'is-invalid' : ''), 'id' => 'status']) !!}
            @error('status')
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
        var token = '{{ csrf_token() }}';
        var prodi = $('#prodi').val();
        var tahun_ajaran = $('#tahun_ajaran').val();
        var semester = $('#semester').val();

        // $(document).on('change','#prodi, #tahun_ajaran, #semester',function(){
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
            var id_tahun_ajaran = $(this).data('id_tahun_ajaran');
            var id_mahasiswa = $(this).data('id_mahasiswa');
            var id_semester = $(this).data('id_semester');
            var id_prodi = $(this).data('id_prodi');
            var status = $(this).data('status');

            $('[name=id_tahun_ajaran]').val(id_tahun_ajaran);
            $('[name=id_mahasiswa]').val(id_mahasiswa);
            $('[name=id_semester]').val(id_semester);
            $('[name=id_prodi]').val(id_prodi);
            $('[name=status]').val(status);

        });
        
    </script>
@endpush