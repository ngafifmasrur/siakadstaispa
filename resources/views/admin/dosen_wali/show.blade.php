@extends('layouts.app')
@section('title', 'Daftar Mahasiswa')

@section('content')
<x-header>
    Daftar Mahasiswa
</x-header>

<x-card-info>
    <x-slot name="title">Dosen Wali: {{ $dosen_wali->dosen->nama_dosen }}</x-slot>
    <x-slot name="button">
        <a class="btn btn-app btn-sm btn-danger" href="{{ route('admin.dosen_wali.index')}}"><i class="fa fa-arrow-left mr-2"></i>Kembali</a>
    </x-slot>

    <table cellpadding="4" cellspacing="2">
        <tr>
            <td class="font-weight-bold">NIDN Dosen Wali</td>
            <td>:</td>
            <td>{{ $dosen_wali->dosen->nidn }}</td>
        </tr>
        <tr>
            <td class="font-weight-bold">Nama Dosen Wali</td>
            <td>:</td>
            <td>{{ $dosen_wali->dosen->nama_dosen }}</td>
        </tr>
    </table>
</x-card-info>

<x-card-table>
    <x-slot name="title">Daftar Mahasiswa</x-slot>
    <x-slot name="button">
        <button onclick="massCreateAccount('{{ route('admin.dosen_wali.copot_pilihan') }}')" class="btn btn-danger btn-xs btn-flat"><i class="fa fa-trash mr-2"></i>Copot Pilihan</button>
    </x-slot>
    
    <form action="" method="post" id="copot-form" class="copot-form">
        @csrf @method('post')
    <x-datatable 
    :route="route('admin.dosen_wali.mahasiswa_wali_index', $dosen_wali->id_dosen)" 
    :table="[
        ['title' => 'checkbox', 'data' => 'select_all', 'name' => 'select_all', 'orderable' => 'false', 'searchable' => 'false', 'width' => '10'],                            
        ['title' => 'No.', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => 'false', 'searchable' => 'false', 'width' => '10'],
        ['title' => 'NIM', 'data' => 'nim', 'name' => 'nim'],
        ['title' => 'Nama Mahasiswa', 'data' => 'nama_mahasiswa', 'name' => 'nama_mahasiswa', 'classname' => 'text-left'],
        ['title' => 'Jenis Kelamin', 'data' => 'jenis_kelamin', 'name' => 'jenis_kelamin', 'classname' => 'text-left'],
        ['title' => 'Program Studi', 'data' => 'nama_program_studi', 'name' => 'nama_program_studi', 'classname' => 'text-left'],
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
        if ($('input:checked').length > 0) {
            if (confirm('Copot mahasiswa yang dipilih?')) {
                $.post(url, $('.copot-form').serialize())
                    .done((response) => {
                        $.growl.notice({ duration: 3000, title: "Berhasil!",message: 'Mahasiswa terpilih berhasil dicopot!' });
                        table.ajax.reload();
                    })
                    .fail((errors) => {
                        $.growl.error({ duration: 3000, title: "Gagal!",message: 'Mahasiswa terpilih gagal dicopot!' });
                        return;
                    });
            }
        } else {
            $.growl.error({ duration: 3000, title: "Gagal!",message: 'Pilih mahasiswa terlebih dahulu!' });
            return;
        }
    }
</script>
@endpush