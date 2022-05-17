@extends('layouts.app')
@section('title', 'Presensi Mahasiswa')

@section('content')

<x-header>
    Mahasiswa
</x-header>

<x-card>
    <div class="row">
        <div class="form-group col-lg-3">
            <label for="prodi">Program Studi</label>
            {!! Form::select('prodi', $prodi, null, ['class' => 'form-control', 'id' => 'prodi']) !!}
        </div>
        <div class="form-group col-lg-3">
            <label for="periode">Periode Masuk</label>
            {!! Form::select('periode', $periode, $semester_id, ['class' => 'form-control', 'id' => 'periode']) !!}
        </div>
    </div>
</x-card>

<x-card-table>
    <x-slot name="title">Data Mahasiswa</x-slot>
    <x-slot name="button">
        {{-- <a class="btn btn-app btn-sm btn-primary" href="{{ route('admin.mahasiswa.create') }}"><i class="fa fa-plus mr-2"></i>Tambah</a> --}}
    </x-slot>
    
    <form action="" method="post" id="mahasiswa-form" class="mahasiswa-form">
        @csrf @method('post')
        <x-datatable 
        :route="route('bendahara.presensi_mahasiswa.data_index')" 
        :table="[
            ['title' => 'No.', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => 'false', 'searchable' => 'false', 'width' => '10'],                            
            ['title' => 'NIM', 'data' => 'nim', 'name' => 'nim'],
            ['title' => 'Nama Mahasiswa', 'data' => 'nama_mahasiswa', 'name' => 'nama_mahasiswa', 'classname' => 'text-left'],
            ['title' => 'Jenis Kelamin', 'data' => 'jenis_kelamin', 'name' => 'jenis_kelamin'],
            ['title' => 'Tanggal Lahir', 'data' => 'tanggal_lahir', 'name' => 'tanggal_lahir'],
            ['title' => 'Cetak Presensi', 'data' => 'action', 'name' => 'action'],
        ]"
        :filter="[
            ['data' => 'prodi', 'value' => '$(`#prodi`).val()'],
            ['data' => 'periode', 'value' => '$(`#periode`).val()'],
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