@extends('layouts.app')
@section('title', 'Presensi Dosen')

@section('content')

<x-header>
    Dosen
</x-header>

<x-card-table>
    <x-slot name="title">Data Dosen</x-slot>
    <x-slot name="button">
        {{-- <a class="btn btn-app btn-sm btn-primary" href="{{ route('admin.mahasiswa.create') }}"><i class="fa fa-plus mr-2"></i>Tambah</a> --}}
    </x-slot>
    
    <form action="" method="post" id="mahasiswa-form" class="mahasiswa-form">
        @csrf @method('post')
        <x-datatable 
        :route="route('bendahara.presensi_dosen.data_index')" 
        :table="[
            ['title' => 'No.', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => 'false', 'searchable' => 'false', 'width' => '10'],                            
            ['title' => 'NIDN', 'data' => 'nidn', 'name' => 'nidn', 'classname' => 'text-left'],
            ['title' => 'Nama', 'data' => 'nama_dosen', 'name' => 'nama_dosen', 'classname' => 'text-left'],
            ['title' => 'NIP', 'data' => 'nip', 'name' => 'nip', 'classname' => 'text-left'],
            ['title' => 'Jenis Kelamin', 'data' => 'jenis_kelamin', 'name' => 'jenis_kelamin', 'classname' => 'text-left'],
            ['title' => 'Cetak Presensi', 'data' => 'action', 'name' => 'action'],
        ]"
        />
    </form>

</x-card-table>


<x-modal.delete/>


@endsection

@push('js')
<script>
        $( document ).ready(function() {
            $(document).on('change','#prodi, #periode',function(){
                table.ajax.reload();
            });
        });
</script>
@endpush