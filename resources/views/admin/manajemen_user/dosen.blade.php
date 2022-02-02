@extends('layouts.app')
@section('title', 'Generate User Dosen')

@section('content')

<x-header>
    Generate User Dosen
</x-header>

<x-card-table>
    <x-slot name="title">Generate User Dosen</x-slot>
    <x-slot name="button">
        <button onclick="massCreateAccount('{{ route('admin.manajemen_user.generate_dosen') }}')" class="btn btn-success btn-xs btn-flat"><i class="fa fa-check"></i> Buat Akun</button>

    </x-slot>
    
    <form action="" method="post" id="dosen-form" class="dosen-form">
        @csrf @method('post')

        <x-datatable :route="route('admin.manajemen_user.dosen_index')"
        :table="[
            ['title' => 'checkbox', 'data' => 'select_all', 'name' => 'select_all', 'orderable' => 'false', 'searchable' => 'false', 'width' => '10'],                            
            ['title' => 'No.', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => 'false', 'searchable' => 'false', 'width' => '10'],
            ['title' => 'Nama Dosen', 'data' => 'nama_dosen', 'name' => 'nama_dosen', 'classname' => 'text-left'],
            ['title' => 'NIDN', 'data' => 'nidn', 'name' => 'nidn', 'classname' => 'text-left'],
            ['title' => 'Status Aktif', 'data' => 'status', 'name' => 'status', 'classname' => 'text-center'],
        ]" />
    </form>
</x-card-table>
@endsection

@push('js')
<script>
    function massCreateAccount(url) {
        if ($('input:checked').length > 0) {
            if (confirm('Buat akun baru untuk dosen yang dipilih?')) {
                $.post(url, $('.dosen-form').serialize())
                    .done((response) => {
                        $.growl.notice({ duration: 3000, title: "Berhasil!",message: 'Akun dosen terpilih berhasil dibuat!' });
                        table.ajax.reload();
                    })
                    .fail((errors) => {
                        $.growl.error({ duration: 3000, title: "Gagal!",message: 'Akun dosen terpilih gagal dibuat!' });
                        return;
                    });
            }
        } else {
            $.growl.error({ duration: 3000, title: "Gagal!",message: 'Pilih dosen terlebih dahulu!' });
            return;
        }
    }
</script>
@endpush
