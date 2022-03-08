@extends('account::layouts.auth')

@section('subtitle', 'Perbarui sandi - ')
@section('card-title', 'Perbarui sandi')

@section('content')
    <form class="form-block" method="POST" action="{{ route('account.broke') }}">
        @csrf
        
        <input type="hidden" name="token" value="{{ $token }}">

        <div class="form-group">
            <label>Sandi baru</label>
            <input type="password" class="form-control" name="password" autofocus required>
            <small class="form-text text-muted">Sandi minimal 4 karakter</small>
        </div>

        <div class="form-group">
            <label>Ulangi sandi</label>
            <input type="password" class="form-control" name="password_confirmation" required>
        </div>

        @if ($errors->has('password'))
            <p class="text-danger">{{ $errors->first('password') }}</p>
        @endif

        <div class="form-group mb-0">
            <button type="submit" class="btn btn-success">Simpan sandi</button>
        </div>
    </form>
@endsection
