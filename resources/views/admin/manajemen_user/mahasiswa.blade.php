@extends('layouts.app')
@section('title', 'Generate User Mahasiswa')

@section('content')

<x-header>
    Generate User Mahasiswa
</x-header>

<x-card-info>
    <ol>
        <li>Fitur ini digunakan untuk melakukan generate Username & Password Mahasiswa.</li>
        <li>Default user yang di-generate untuk username : <strong>NIM</strong> & password : <strong>Tanggal Lahir</strong> dengan format yyyy-mm-dd (tanda '-' dihilangkan ). Contoh : 1999-12-01 -> 19991201</li>
        <li>Untuk melihat daftar user <a href="{{ route('admin.manajemen_user.index')}}">disini</a></li>
    </ol>
</x-card-info>

<x-card>
    <div class="row">
        <div class="form-group col-lg-3">
            <label for="prodi">Program Studi</label>
            {!! Form::select('id_prodi', $prodi, null, ['class' => 'form-control', 'id' => 'prodi']) !!}
        </div>
        <div class="form-group col-lg-3">
            <label for="tahun_ajaran">Angkatan</label>
            {!! Form::select('id_periode', $semester, null, ['class' => 'form-control', 'id' => 'periode']) !!}
        </div>
    </div>
</x-card>

<x-card-table>
    <x-slot name="title">Generate User Mahasiswa</x-slot>
    <x-slot name="button">
        <button onclick="massCreateAccount('{{ route('admin.manajemen_user.generate_mahasiswa') }}')" class="btn btn-success btn-xs btn-flat"><i class="fa fa-check"></i> Generate Akun</button>
    </x-slot>
    
    <form action="" method="post" id="mahasiswa-form" class="mahasiswa-form">
        @csrf @method('post')
        <x-datatable 
        :route="route('admin.manajemen_user.mahasiswa_index')" 
        :table="[
            ['title' => 'checkbox', 'data' => 'select_all', 'name' => 'select_all', 'orderable' => 'false', 'searchable' => 'false', 'width' => '10'],                            
            ['title' => 'No.', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => 'false', 'searchable' => 'false', 'width' => '10'],                            
            ['title' => 'Nama Mahasiswa', 'data' => 'nama_mahasiswa', 'name' => 'nama_mahasiswa', 'classname' => 'text-left'],
            ['title' => 'Tanggal Lahir', 'data' => 'tanggal_lahir', 'name' => 'tanggal_lahir', 'classname' => 'text-center'],
            ['title' => 'NIM', 'data' => 'nim', 'name' => 'nim'],
            ['title' => 'Program Studi', 'data' => 'nama_program_studi', 'name' => 'nama_program_studi'],
            ['title' => 'Angkatan', 'data' => 'nama_periode_masuk', 'name' => 'nama_periode_masuk'],
        ]"
        :filter="[
            ['data' => 'id_prodi', 'value' => '$(`#prodi`).val()'],
            ['data' => 'id_periode', 'value' => '$(`#periode`).val()']
        ]"
        />
    </form>

</x-card-table>
@endsection

@push('js')
<script>
    $( document ).ready(function() {
        $(document).on('change','#prodi, #periode',function(){
            table.ajax.reload();
        });
    });


    function massCreateAccount(url) {
        if ($('input:checked').length > 0) {
            if (confirm('Buat '+$('input:checked').length+' akun baru mahasiswa?')) {
                $.post(url, $('.mahasiswa-form').serialize())
                    .done((response) => {
                        $.growl.notice({ duration: 3000, title: "Berhasil!",message: 'Akun mahasiswa terpilih berhasil dibuat!' });
                        table.ajax.reload();
                    })
                    .fail((errors) => {
                        $.growl.error({ duration: 3000, title: "Gagal!",message: 'Akun mahasiswa terpilih gagal dibuat!' });
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