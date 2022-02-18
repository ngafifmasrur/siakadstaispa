@extends('layouts.app')
@section('title', 'Tambah Kartu Rencana Studi')

@section('content')

<x-header>
    Tambah Kartu Rencana Studi
</x-header>

<x-card>
    <div class="row">
        <div class="form-group col-lg-3">
            <label for="semester">Pilih Semester</label>
            {!! Form::select('semester', $semester, null, ['class' => 'form-control', 'id' => 'semester']) !!}
        </div>
    </div>
</x-card>

<x-card-table>
    <x-slot name="title">Pilih Kelas Kuliah</x-slot>
    <x-slot name="button">
        <a class="btn btn-app btn-sm btn-danger" href="{{ route('mahasiswa.krs.index') }}"><i class="fa fa-arrow-left mr-2"></i>Kembali</a>
        <button onclick="massCreateAccount()" class="btn btn-app btn-success btn-sm"><i class="fa fa-check"></i> Simpan</button>
    </x-slot>

    @if (Session::get('results'))
    <div class="alert alert" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <hr class="message-inner-separator">
        <ul>
            @foreach(Session::get('results') as $key => $item)
                @if ($item['error_code'] !== '0')
                <li class="text-danger">{{ $item['error_code'].' - '.$item['error_desc'] }}</li>
                @else
                <li class="text-success" style="color:#00C851!important">Berhasil Disimpan!</li>
                @endif
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
            ['title' => 'SMT', 'data' => 'smt', 'name' => 'smt'],
            ['title' => 'Kelas', 'data' => 'nama_kelas_kuliah', 'name' => 'nama_kelas_kuliah','classname' => 'text-left'],
            ['title' => 'Jadwal', 'data' => 'jadwal', 'name' => 'jadwal','classname' => 'text-left'],
            ['title' => 'SKS', 'data' => 'sks_mata_kuliah', 'name' => 'sks_mata_kuliah'],
        ]"
        :filter="[
            ['data' => 'semester', 'value' => '$(`#semester`).val()']
        ]"
        />
    </form>

</x-card-table>
@endsection

@push('js')
<script>
    $( document ).ready(function() {
        $(document).on('change','#semester',function(){
            table.ajax.reload();
        });
    });

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