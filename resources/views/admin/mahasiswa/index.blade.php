@extends('layouts.app')
@section('title', 'Mahasiswa')

@section('content')

<x-header>
    Mahasiswa
</x-header>
<!-- Main page content-->
<div class="container mt-n10">
    <div class="row">
        <div class="col-lg-12">
            <form action="" method="post">
                <div class="card">
                    <div class="card-header">
                        Data Mahasiswa
                        <a class="float-right btn btn-sm btn-outline-blue " data-url="{{ route('admin.mahasiswa.create') }}" href="{{ route('admin.mahasiswa.create') }}"><i data-feather="plus" class="mr-2"></i>Tambah</a>
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
                        :route="route('admin.mahasiswa.data_index')" 
                        :table="[
                            ['title' => 'No.', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => 'false', 'searchable' => 'false', 'width' => '10'],                            
                            ['title' => 'NIK', 'data' => 'nik', 'name' => 'nik'],
                            ['title' => 'Nama Mahasiswa', 'data' => 'nama_mahasiswa', 'name' => 'nama_mahasiswa', 'classname' => 'text-left'],
                            ['title' => 'Jenis Kelamin', 'data' => 'jenis_kelamin', 'name' => 'jenis_kelamin'],
                            ['title' => 'Tanggal Lahir', 'data' => 'tanggal_lahir', 'name' => 'tanggal_lahir'],
                            ['title' => 'Agama', 'data' => 'agama', 'name' => 'agama'],
                            ['title' => 'Aksi', 'data' => 'action', 'orderable' => 'false', 'searchable' => 'false'],
                        ]"
                        />
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>

<x-modal.delete/>


@endsection

@push('js')

@endpush