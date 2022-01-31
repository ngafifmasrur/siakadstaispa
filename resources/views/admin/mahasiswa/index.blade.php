@extends('layouts.app')
@section('title', 'Mahasiswa')

@section('content')

<x-header>
    Mahasiswa
</x-header>

<x-card-table>
    <x-slot name="title">Data Mahasiswa</x-slot>
    <x-slot name="button">
        {{-- <a class="btn btn-app btn-sm btn-primary" href="{{ route('admin.mahasiswa.create') }}"><i class="fa fa-plus mr-2"></i>Tambah</a> --}}
        <button onclick="massCreateAccount('{{ route('admin.mahasiswa.buat_akun') }}')" class="btn btn-success btn-xs btn-flat"><i class="fa fa-check"></i> Buat Akun</button>
    </x-slot>
    
    <form action="" method="post" id="mahasiswa-form" class="mahasiswa-form">
        @csrf @method('post')
        <x-datatable 
        :route="route('admin.mahasiswa.data_index')" 
        :table="[
            ['title' => 'No.', 'data' => 'select_all', 'name' => 'select_all', 'orderable' => 'false', 'searchable' => 'false', 'width' => '10'],                            
            ['title' => 'No.', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => 'false', 'searchable' => 'false', 'width' => '10'],                            
            ['title' => 'NIM', 'data' => 'nim', 'name' => 'nim'],
            ['title' => 'Nama Mahasiswa', 'data' => 'nama_mahasiswa', 'name' => 'nama_mahasiswa', 'classname' => 'text-left'],
            ['title' => 'Jenis Kelamin', 'data' => 'jenis_kelamin', 'name' => 'jenis_kelamin'],
            ['title' => 'Tanggal Lahir', 'data' => 'tanggal_lahir', 'name' => 'tanggal_lahir'],
            ['title' => 'Agama', 'data' => 'agama', 'name' => 'agama'],
            ['title' => 'Aksi', 'data' => 'action', 'orderable' => 'false', 'searchable' => 'false'],
        ]"
        />
    </form>

</x-card-table>


<x-modal.delete/>


@endsection

@push('js')
<script>
    function massCreateAccount(url) {
        if ($('input:checked').length > 1) {
            if (confirm('Buat akun baru untuk mahasiswa yang dipilih?')) {
                $.post(url, $('.mahasiswa-form').serialize())
                    .done((response) => {
                        table.ajax.reload();
                    })
                    .fail((errors) => {
                        return;
                    });
            }
        } else {
            return;
        }
    }
</script>
@endpush