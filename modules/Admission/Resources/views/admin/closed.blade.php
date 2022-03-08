@extends('admission::admin.layouts.admin')

@section('subtitle', '404 - ')

@section('breadcrumb')
    <li class="breadcrumb-item">Admin</li>
    <li class="breadcrumb-item active">404</li>
@endsection

@section('content')
<div >
    <div class="d-flex align-items-center" style="height: 68vh;">
        <div class="row justify-content-center w-100">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body text-center py-5">
                        <h1 style="font-size: 8em; margin: 0; font-family: sans-serif;"><strong>404</strong></h1>
                        <h2><strong>Halaman tidak ditemukan</strong></h2>
                        Tidak ada pendaftaran yang dibuka, silahkan hubungi administrator pusat untuk membuka pendaftaran.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop