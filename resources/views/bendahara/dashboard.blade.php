@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')

<div class="page-header">
    <ol class="breadcrumb"><!-- breadcrumb -->
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <?php
            $segments = '';
            $total_segments = count(Request::segments());
        ?>
        @foreach(Request::segments() as $key => $segment)
            <?php $segments .= '/'.$segment; ?>
            <li class="breadcrumb-item {{ $key+1 == $total_segments ? 'active' : ''}}" aria-current="page">{{ ucwords(str_replace('_', ' ',$segment)) }}</li>
        @endforeach
    </ol>
</div>

<div class="col-xl-12 col-lg-12 col-md-12">
    <div class="row">
        <div class="col-xl-3 col-lg-6">
            <div class="card overflow-hidden">
                <div class="card-body pb-0">
                    <div class="d-flex">
                        <div>
                            <p class="mb-1 text-uppercase">Jumlah Dosen</p>
                        <h2 class="fs-2 mb-3">{{ $total_dosen }}</h2>
                        <a href="{{ route('admin.dosen.index') }}" class="btn btn-secondary view-more mb-3">List Dosen</a>
                        </div>
                        <i class="fa fa-user fa-5x ml-auto fs-3 op4 text-danger"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6">
            <div class="card overflow-hidden">
                <div class="card-body pb-0">
                    <div class="d-flex">
                        <div>
                            <p class="mb-1 text-uppercase">Jumlah Mahasiswa</p>
                        <h2 class="fs-2 mb-3">{{ $total_mhs }}</h2>
                        <a href="{{ route('admin.mahasiswa.index') }}" class="btn btn-secondary view-more mb-3">List Mahasiswa</a>
                        </div>
                        <i class="fa fa-user fa-5x ml-auto fs-3 op4 text-danger"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('css')
    <style>
        .view-more {
            /* border-radius: 10rem; */
            /* padding-left: 0.9em; */
            /* padding-right: 0.9em; */
            padding-top: 0.1em;
            padding-bottom: 0.1em;
        }
    </style>
@endpush