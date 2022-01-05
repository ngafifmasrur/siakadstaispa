@extends('layouts.app')
@section('title', 'Kelas Kuliah')

@section('content')

<x-header>
    Peserta Kelas Kuliah
</x-header>
<!-- Main page content-->
<div class="container mt-n10">
    <div class="row">
        <div class="col-lg-12">
            <form action="" method="post">
                <div class="card">
                    <div class="card-header">
                        Peserta Kelas Kuliah
                        {{-- <a class="float-right btn btn-sm btn-outline-blue add-form" data-url="{{ route('admin.kelas_kuliah.store') }}" href="#"><i data-feather="plus" class="mr-2"></i>Tambah</a> --}}
                    </div>
                    
                    <div class="card-body">
                        @if ($errors->any())
                        <div class="alert alert-danger alert-icon" role="alert">
                            <button class="close" type="button" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                            <div class="alert-icon-content">
                                <h6 class="alert-heading">Error, Periksa Ulang data..</h6>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        @endif

                        <x-datatable 
                        :route="route('admin.peserta_kelas_kuliah.data_index')" 
                        :table="[
                            ['title' => 'No.', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => 'false', 'searchable' => 'false', 'width' => '10'],                            
                            ['title' => 'Nama Kelas', 'data' => 'nama_kelas_kuliah', 'name' => 'nama_kelas_kuliah', 'classname' => 'text-left'],
                            ['title' => 'Program Studi', 'data' => 'prodi', 'name' => 'prodi', 'classname' => 'text-left'],
                            ['title' => 'Semester', 'data' => 'semester', 'name' => 'semester'],
                            ['title' => 'Matkul', 'data' => 'matkul', 'name' => 'matkul'],
                            ['title' => 'Aksi', 'data' => 'action', 'orderable' => 'false', 'searchable' => 'false'],
                        ]"
                        />
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>


@endsection

@push('js')

@endpush