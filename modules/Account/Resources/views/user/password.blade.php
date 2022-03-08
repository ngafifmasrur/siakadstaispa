@extends('account::layouts.auth')

@section('subtitle', 'Ubah sandi - ')
@section('card-title', 'Ubah sandi')

@section('content')
    <form class="form-block" method="POST" action="{{ route('account.user.password', ['next' => request('next')]) }}">
        @csrf @method('PUT')
        
        <p>Pilih sandi yang kuat dan jangan gunakan lagi untuk akun lain.</p>

        <div class="form-group required">
            <label class="col-form-label">Sandi lama</label>
            <input type="password" class="form-control @error('old_password') is-invalid @enderror" name="old_password" required autofocus>
            <small class="form-text text-muted">Masukkan sandi lama untuk memverifikasi bahwa ini memang Anda.</small>
            @error('old_password') 
                <span class="invalid-feedback"> {{ $message }} </span>
            @enderror
        </div>
        <div class="form-group required">
            <label class="col-form-label">Sandi</label>
            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
            <small class="form-text text-muted">Gunakan sedikitnya 8 karakter. Jangan gunakan sandi dari situs lain atau sesuatu yang mudah ditebak seperti tanggal lahir Anda.</small>
        </div>
        <div class="form-group required">
            <label class="col-form-label">Konfirmasi sandi</label>
            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password_confirmation" required>
            @error('password') 
                <span class="invalid-feedback"> {{ $message }} </span>
            @enderror
        </div>

        <div class="form-group mb-0">
            <button type="submit" class="btn btn-success">Simpan sandi</button>
            <a class="btn btn-secondary" href="{{ request('next', url()->previous()) }}">Kembali</a>
        </div>
    </form>
@endsection
