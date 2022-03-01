@extends('account::layouts.auth')

@section('subtitle', 'Buat akun - ')
@section('card-title', 'Buat akun')

@section('content')
    <form class="form-block" method="POST" action="{{ route('account.register', ['next' => request('next')]) }}"> @csrf
        @if(request('next'))
            <p class="text-danger">Silahkan buat akun untuk melanjutkan</p>
        @endif
        <div class="form-group">
            <label>Nama lengkap</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autofocus>
            <small class="form-text text-muted">Nama lengkap Anda. Sesuai KTP/KK/Identitas resmi lainnya</small>
            @error('name')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="form-group">
            <label>Username</label>
            <div class="input-group">
                <input type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autofocus>
                <div class="input-group-append">
                    <div class="input-group-text">{{ '@'.env('APP_DOMAIN') }}</div>
                </div>      
            </div>
            <small class="form-text text-muted">Nama unik pengguna (bukan nama lengkap), digunakan untuk login, terdiri dari huruf kecil, titik, dan angka, tanpa spasi. </small>
            @error('username')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="form-group">
            <label>Sandi</label>
            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
        </div>
        <div class="form-group">
            <label>Ulangi sandi</label>
            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password_confirmation" required>
            @error('password')
            <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group mb-0">
            <p class="text-muted">Dengan menekan tombol "Buat akun" saya menyetujui syarat & ketentuan layanan.</p>
            <button type="submit" class="btn btn-success">Buat akun</button>
            <a class="btn btn-secondary" href="{{ url()->previous() }}">Kembali</a>
        </div>
    </form>
@endsection

{{-- @section('oauth')
    <div class="list-group list-group-flush">
        <a class="list-group-item border-0 list-group-item-action list-group-item-success" href="{{ route('account.oauth2.login', ['next' => request('next')]) }}">
            Daftar menggunakan Akun Pandanaran
        </a>
    </div>
@endsection --}}

@push('script')
    {{-- <div class="container">
        <div class="modal fade" tabindex="-1" role="dialog" id="login" data-backdrop="static">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body row justify-content-center">
                        <div class="col-md-8 py-md-5 text-center">
                            <p>
                                <img src="{{ asset('assets/img/logo/icon-rn64.png') }}" alt="">
                            </p>
                            <h3>Coba daftar dengan metode baru!</h3>
                            <hr>
                            <p>Saat ini <strong>{{ env('APP_NAME') }}</strong> terhubung dengan <strong>{{ env('OAUTH2_NAME') }}</strong>, silahkan tekan tombol dibawah untuk mencoba daftar dengan <strong>{{ env('OAUTH2_NAME') }}</strong></p>
                            <p><a class="btn btn-dark" style="white-space: pre-wrap;" href="{{ route('account.oauth2.login') }}">Daftar dengan {{ env('OAUTH2_NAME') }}</a></p>
                            <button id="tl-dismiss" class="btn btn-link text-muted" style="white-space: pre-wrap;" data-dismiss="modal">Lanjutkan dengan pendaftaran akun MASPA</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(() => {
            if (!localStorage.getItem('tl') || localStorage.getItem('tl') < (Date.now() - (60*60*1000))) {
                $('#login').modal('show');
            }
            $('#login').on('hidden.bs.modal', function () {
                localStorage.setItem('tl', Date.now());
            })
        })
    </script> --}}
@endpush