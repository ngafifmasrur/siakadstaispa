@extends('layouts.app')
@section('title', 'Tambah Kartu Rencana Studi')

@section('content')

<x-header>
    Tambah Kartu Rencana Studi
</x-header>

<x-card-table>
    <x-slot name="title">Pilih Kelas Kuliah</x-slot>
    <x-slot name="button">
        <button onclick="massCreateAccount()" class="btn btn-success btn-xs btn-flat"><i class="fa fa-check"></i> Simpan</button>
    </x-slot>

    @if (Session::get('results'))
    <div class="alert alert-danger" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <strong>Error, Periksa Ulang data input...</strong>
        <hr class="message-inner-separator">
        <ul>
            @foreach(Session::get('results') as $key => $item)
                <li>{{ $item['error_code'].' - '.$item['error_desc'] }}</li>
            @endforeach 
        </ul>
    </div>
    @endif
    
    <form action="{{ route('mahasiswa.krs.store') }}" method="post" id="kelas_form" class="kelas-form">
        @csrf @method('post')
        <x-datatable 
        :route="route('mahasiswa.krs.list_kelas_kuliah')" 
        :table="[
            ['title' => 'checkbox', 'data' => 'select_all', 'name' => 'select_all', 'orderable' => 'false', 'searchable' => 'false', 'width' => '10'],
            ['title' => 'No.', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => 'false', 'searchable' => 'false', 'width' => '10'],                            
            ['title' => 'Nama Mata Kuliah', 'data' => 'nama_mata_kuliah', 'name' => 'nama_mata_kuliah','classname' => 'text-left'],
            ['title' => 'Kelas', 'data' => 'nama_kelas_kuliah', 'name' => 'nama_kelas_kuliah','classname' => 'text-left'],
            ['title' => 'Dosen Pengajar', 'data' => 'nama_dosen', 'name' => 'nama_dosen', 'classname' => 'text-left'],
            ['title' => 'Ruangan', 'data' => 'ruangan', 'name' => 'ruangan','classname' => 'text-left'],
            ['title' => 'Kapasitas Kelas', 'data' => 'kapasitas', 'name' => 'kapasitas'],
        ]"
        />
    </form>

</x-card-table>
@endsection

@push('js')
<script>
    function massCreateAccount() {
        if ($('input:checked').length > 0) {
            if (confirm('Simpan '+$('input:checked').length+' kelas kuliah?')) {
                document.getElementById('kelas_form').submit();
            }
        } else {
            $.growl.error({ duration: 3000, title: "Gagal!",message: 'Pilih kelas kuliah terlebih dahulu!' });
            return;
        }
    }
</script>
@endpush