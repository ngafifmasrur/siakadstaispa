@extends('admission::layouts.default')

@section('subtitle', 'Pendaftaran - ')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <h4 class="mb-0">{{ config('admission.head.title') }}</h4>
            </div>
        </div>

        <hr>

        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                
                <p class="text-muted">Silahkan isi data awal dibawah ini untuk melanjutkan.</p>

                <form class="form-block" method="POST" action="{{ route('admission.register', ['next' => request('next')]) }}">
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
                        <input type="text" class="form-control" value="{{ $user->profile->name }}" disabled readonly>
                    </div>


                    <div class="form-group required w-75">
                        <label>Tempat lahir</label>
                        <input type="text" class="form-control @error('pob') is-invalid @enderror" name="pob" value="{{ old('pob', $user->profile->pob) }}" autofocus>
                        <small class="form-text text-muted">Diisi dengan menggunakan huruf kapital dan sesuai dengan Kartu Keluarga atau akta kelahiran </small>
                        @error('pob')
                            <span class="invalid-feedback"> {{ $message }} </span>
                        @enderror
                    </div>

                    <div class="form-group required w-75">
                        <label>Tanggal lahir</label>
                        <div class="input-group date" id="dob" data-target-input="nearest">
                            <input type="text" class="form-control datetimepicker-input @error('dob') is-invalid @enderror" name="dob" value="{{ old('dob', ($user->profile->dob ? $user->profile->dob->format('d-m-Y') : '')) }}" data-toggle="datetimepicker" data-target="#dob">
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
                                    <input class="custom-control-input" id="sex{{ $sexid }}" type="radio" value="{{ $sexid }}" name="sex" @if(old('sex', $user->profile->sex ?? -1) == $sexid) checked @endif required>
                                    <label class="custom-control-label" for="sex{{ $sexid }}">{{ $sex }}</label>
                                </div>
                            @endforeach
                        </div>
                        @error('name')
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