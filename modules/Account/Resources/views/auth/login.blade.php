@extends('account::layouts.auth')

@section('subtitle', 'Masuk - ')
@section('card-title', 'Masuk')

@section('content')
    <form class="form-block" method="POST" action="{{ route('account.login', ['next' => request('next')]) }}"> @csrf
        @if(request('next'))
            <p class="text-danger">Silahkan masuk untuk melanjutkan</p>
        @endif
        <div class="form-group">
            <label>Username</label>
            <div class="input-group">
                <input type="text" class="form-control" name="username" value="{{ old('username') }}" required @if(!old('username')) autofocus @endif>
                <div class="input-group-append">
                    <div class="input-group-text">{{ '@'.env('APP_DOMAIN') }}</div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label>Sandi</label>
            <input type="password" class="form-control" name="password" value="{{ old('password') }}" required required @if(old('username')) autofocus @endif>
        </div>
        @if ($errors)
        <p class="text-danger"> {{ $errors->first() }} </p>
        @endif
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <div class="custom-control custom-checkbox">
                        <input class="custom-control-input" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }} id="remember">
                        <label class="custom-control-label" for="remember">Ingat saya</label>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <p class="text-sm-right"><a href="{{ route('account.forgot') }}">Lupa sandi?</a></p>
            </div>
        </div>
        <div class="form-group mb-0">
            <button type="submit" class="btn btn-success">Masuk</button>
        </div>
    </form>
@endsection