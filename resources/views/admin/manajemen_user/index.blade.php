@extends('layouts.app')
@section('title', 'Daftar User')

@section('content')

<x-header>
    Daftar User
</x-header>

<x-card>
    <div class="row">
        <div class="form-group col-lg-3">
            <label for="prodi">Role</label>
            {!! Form::select('role_id', $role, null, ['class' => 'form-control', 'id' => 'role_id']) !!}
        </div>
    </div>
</x-card>

<x-card-table>
    <x-slot name="title">Daftar User</x-slot>
    <x-slot name="button">
        <a href="{{ route('admin.manajemen_user.mahasiswa') }}" class="btn btn-primary btn-xs btn-flat"><i class="fa fa-plus"></i> Generate Akun Mahasiswa</a>
        <a href="{{ route('admin.manajemen_user.dosen') }}" class="btn btn-primary btn-xs btn-flat"><i class="fa fa-plus"></i> Generate Akun Dosen</a>

    </x-slot>

    <form action="" method="post" id="mahasiswa-form" class="mahasiswa-form">
        @csrf @method('post')
        <x-datatable 
        :route="route('admin.manajemen_user.data_index')" 
        :table="[
            ['title' => 'No.', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => 'false', 'searchable' => 'false', 'width' => '10'],                            
            ['title' => 'Nama', 'data' => 'name', 'name' => 'name', 'classname' => 'text-left'],
            ['title' => 'Email', 'data' => 'email', 'name' => 'email', 'classname' => 'text-left'],
            ['title' => 'Role', 'data' => 'role', 'name' => 'role'],
            ['title' => 'Aksi', 'data' => 'action', 'name' => 'action'],
        ]"
        :filter="[
            ['data' => 'role_id', 'value' => '$(`#role_id`).val()'],
        ]"
        />
    </form>

</x-card-table>

<x-modal.delete />

<x-modal class="modal-form" id="modal-form">
    <x-slot name="title">Ubah Password</x-slot>
    <x-slot name="modalPosition">modal-dialog-centered</x-slot>

    @csrf
    @method('put')
    <div class="form-group row">
        <label for="password" class="col-sm-3 col-form-label">Password Baru<span class="text-danger">*</span> </label>
        <div class="col-sm-9">
            <input type="password" class="form-control" placeholder="Minimal 6.." name="password" id="password" required>
        </div>
    </div>
    <div class="form-group row">
        <label for="password_confirmation" class="col-sm-3 col-form-label">Konfirmasi Password<span class="text-danger">*</span> </label>
        <div class="col-sm-9">
            <input type="password" class="form-control" placeholder="Ulangi Password Baru.." name="password_confirmation" id="password_confirmation" required>
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
        $('.modal-form form').attr('action', $(this).data('route'));
        $('[name=_method]').val('put');
    });

    $( document ).ready(function() {
        $(document).on('change','#role_id',function(){
            table.ajax.reload();
        });
    });
</script>
@endpush