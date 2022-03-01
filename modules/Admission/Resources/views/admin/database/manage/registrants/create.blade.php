@extends('admission::admin.layouts.admin')

@section('subtitle', 'Kelola calon mahasiswa baru - ')

@section('breadcrumb')
	<li class="breadcrumb-item">Pangkalan data</li>
	<li class="breadcrumb-item">Kelola</li>
    <li class="breadcrumb-item"><a href="{{ route('admission.admin.database.manage.registrants.index') }}">Calon mahasiswa baru</a></li>
    <li class="breadcrumb-item active">Tambah</li>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-sm-8">
            <h2 class="mb-0">
                <a class="text-decoration-none small" href="{{ request('next', route('admission.admin.database.manage.registrants.index')) }}"><i class="mdi mdi-arrow-left-circle"></i></a> Daftarkan mahasiswa baru
            </h2>
            <hr>
            <div class="card">
                <div class="card-body">
                    <form class="form-block" method="POST" action="{{ route('admission.admin.database.manage.registrants.store', ['next' => request('next')]) }}">
                        @csrf
                        <div class="form-group required">
                            <label>Jalur pendaftaran</label> <br>
                            <div class="btn-group-toggle d-inline" data-toggle="buttons">
                                @forelse($admissions as $admission)
                                    <label class="btn btn-outline-success my-1 my-sm-0 @if(old('admission_id') == $admission->id || count($admissions) == 1) active @endif">
                                        <input type="radio" value="{{ $admission->id }}" name="admission_id" autocomplete="off" autocomplete="off" @if(old('admission_id') == $admission->id) checked @endif> <span class="mdi mdi-location-enter"></span> <br> {{ $admission->name.' '.$admission->period->name }}
                                    </label>
                                @empty
                                    <button type="button" class="btn btn-success disabled">Tidak ada jalur pendaftaran</button>
                                @endforelse
                            </div>
                            @error('admission_id')
                                <div class="text-danger mt-2"> <small>{{ $message }}</small> </div>
                            @enderror
                        </div>

                        <div class="form-group required">
                            <label>Nama lengkap</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" autofocus>
                            <small class="form-text text-muted">Diisi dengan menggunakan huruf kapital dan sesuai dengan Kartu Keluarga atau akta kelahiran </small>
                            @error('name')
                                <span class="invalid-feedback"> {{ $message }} </span>
                            @enderror
                        </div>

                        <div class="form-group required w-75">
                            <label>Tempat lahir</label>
                            <input type="text" class="form-control @error('pob') is-invalid @enderror" name="pob" value="{{ old('pob') }}" autofocus>
                            <small class="form-text text-muted">Diisi dengan menggunakan huruf kapital dan sesuai dengan Kartu Keluarga atau akta kelahiran </small>
                            @error('pob')
                                <span class="invalid-feedback"> {{ $message }} </span>
                            @enderror
                        </div>

                        <div class="form-group required w-75">
                            <label>Tanggal lahir</label>
                            <div class="input-group date" id="dob" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input @error('dob') is-invalid @enderror" name="dob" value="{{ old('dob') }}" data-toggle="datetimepicker" data-target="#dob">
                                <div class="input-group-append" data-target="#dob" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="mdi mdi-calendar"></i></div>
                                </div>
                            </div>
                            @error('dob')
                                <small class="text-danger"> {{ $message }} </small>
                            @enderror
                            <small class="form-text text-muted">Diisi dengan format hh-bb-tttt (ex: 23-02-{{ substr(config('admission.maximum-dob-year'), 0, 4) }}) dan sesuai dengan Kartu Keluarga atau akta kelahiran </small>
                        </div>

                        <div class="form-group required">
                            <label>Jenis kelamin</label>
                            <div class="col-form-label">
                                @foreach(config('web.references.sexes') as $sexid => $sex)
                                    <div class="custom-control custom-radio mb-2">
                                        <input class="custom-control-input" id="sex{{ $sexid }}" type="radio" value="{{ $sexid }}" name="sex" @if(old('sex') == $sexid) checked @endif required>
                                        <label class="custom-control-label" for="sex{{ $sexid }}">{{ $sex }}</label>
                                    </div>
                                @endforeach
                            </div>
                            @error('name')
                                <span class="invalid-feedback"> {{ $message }} </span>
                            @enderror
                        </div>

                        <hr>

                        <div class="form-group required w-75">
                            <label>Username</label>
                            <div class="input-group">
                                <input type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" autofocus>
                                <div class="input-group-append">
                                    <div class="input-group-text">{{ '@'.env('APP_DOMAIN') }}</div>
                                </div>
                            </div>
                            <small class="form-text text-muted">Nama unik pengguna (bukan nama lengkap), digunakan untuk login, terdiri dari huruf kecil, titik, dan angka, tanpa spasi. </small>
                            @error('username')
                                <small class="text-danger"> {{ $message }} </small>
                            @enderror
                        </div>

                        <div class="form-group required w-75">
                            <label>Sandi</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" value="{{ old('password') }}" autofocus>
                            @error('password')
                                <span class="invalid-feedback"> {{ $message }} </span>
                            @enderror
                        </div>

                        <p class="form-text text-muted">Dengan menekan tombol "Selanjutnya", saya sebagai calon mahasiswa telah menyetujui segala persyaratan dan ketentuan layanan yang berlaku.</p>

                        <div class="form-group">
                            <button type="submit" class="btn btn-success">Selanjutnya</button>
                            <a class="btn btn-secondary" href="{{ url()->previous() }}">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script type="text/javascript">
        $(function () {
            $('#dob').datetimepicker({
                maxDate: moment(),
                useCurrent: false,
                viewMode: 'years',
                format: 'DD-MM-YYYY'
            });
        })
    </script>
@endpush