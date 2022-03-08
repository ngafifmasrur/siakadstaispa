@extends('account::layouts.auth')

@section('subtitle', 'Lupa sandi - ')
@section('card-title', 'Lupa sandi')

@section('content')
    <form class="form-block" method="POST" action="{{ route('account.forgot') }}">
        @csrf
        <div class="form-group">
            <label>Alamat e-mail</label>
            <input type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
            <small class="form-text text-muted">Link permintaan pengaturan ulang sandi akan dikirimkan melalui alamat e-mail yang Anda isi</small>
        </div>
        @if ($errors->has('email'))
            <p class="text-danger">{{ $errors->first('email') }}</p>
        @endif

        <div class="form-group mb-0">
            <button type="submit" class="btn btn-success">Kirim</button>
            <a href="{{ route('account.login') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </form>
@endsection
