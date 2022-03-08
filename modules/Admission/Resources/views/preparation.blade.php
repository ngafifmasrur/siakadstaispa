@extends('admission::layouts.default')

@section('subtitle', 'Persiapan - ')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <h4 class="mb-0">Apakah Anda memiliki Akun {{ env('APP_NAME') }}?</h4>
            </div>
        </div>

        <hr>

        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                
                <p class="text-muted">Pendaftaran Santri Baru menggunakan <strong>Akun {{ env('APP_NAME') }}</strong></p>
                <p class="text-muted">Jika Anda belum memiliki Akun, silahkan buat akun Anda sekarang</p>

                <a class="btn btn-success my-1" href="{{ route('admission.register') }}">Ya, saya sudah punya akun</a>
                <a class="btn btn-outline-success my-1" href="{{ route('account.register', ['next' => route('admission.register')]) }}">Belum punya, buat Akun</a>
                
            </div>
        </div>
    </div>
@endsection