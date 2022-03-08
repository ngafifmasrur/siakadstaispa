@extends('admission::layouts.default')

@section('subtitle', 'Pemilihan tanggal tes - ')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <h2 class="mb-0"><a class="text-decoration-none small" href="{{ request('next', url()->previous()) }}"><i class="icon-arrow-left-circle"></i></a> Pemilihan tanggal tes</h2>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <p>Tentukan kapan Anda ingin melaksanakan tes di lokasi pendaftaran.</p>
                <div class="card">
                    <div class="card-body">
                        <h5 class="mb-0">Pemilihan tanggal tes</h5>
                    </div>
                    <div class="card-body border-top">
                        @if(is_null($registrant->tested_at))
                            <form class="form-block" action="{{ route('admission.form.test', ['next' => request('next')]) }}" method="POST"> @csrf @method('PUT')
                                <fieldset>
                                    <div class="row">
                                        <div class="col-md-8 offset-md-4">
                                            <h5 class="text-muted font-weight-normal mb-3">Tanggal tes</h5>
                                        </div>
                                    </div>
                                    <div class="form-group required row">
                                        <label class="col-md-4 col-form-label text-md-right">Tanggal tes</label>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control datetimepicker-input @error('test_at') is-invalid @enderror" id="test_at" name="test_at" value="{{ old('test_at', (isset($registrant->test_at) ? $registrant->test_at->format('d-m-Y') : '')) }}" required data-toggle="datetimepicker" data-target="#test_at" autocomplete="off">
                                            <small class="form-text text-muted">Pilih tanggal tes di lokasi pendaftaran, kuota maksimal adalah {{ config('admission.maximum-test-per-day') }} per tanggal yang ditentukan</small>
                                            @error('test_at')
                                                <span class="invalid-feedback">{{ $message }} </span> 
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group required row">
                                        <label class="col-md-4 col-form-label text-md-right">Sesi tes</label>
                                        <div class="col-md-8">
                                            <select class="js-example-basic-single form-control @error('session') is-invalid @enderror" name="session" required>
                                                <option value="">-- Pilih --</option>
                                                @foreach($registrant->admission->sessions as $session)
                                                    <option value="{{ $session->id }}" @if($registrant->session_id == $session->id) selected @endif>{{ $session->name.' ('.$session->range.')' }}</option>
                                                @endforeach
                                            </select>
                                            @error('session')
                                                <span class="invalid-feedback">{{ $message }} </span> 
                                            @enderror
                                        </div>
                                    </div>
                                </fieldset>
                                <hr>
                                <div class="row">
                                    <div class="col-md-8 offset-md-4">
                                        <button class="btn btn-success" type="submit">Simpan</button>
                                        <a class="btn btn-secondary" href="javascript:history.go(-1);">Kembali</a>
                                    </div>
                                </div>
                            </form>
                        @else
                            <p class="mb-0">Mohon maaf, Anda tidak dapat merubah tanggal tes karena sudah dinyatakan lulus.</p>
                        @endif
                    </div>      
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script type="text/javascript">
        $(function () {
            $('#test_at').datetimepicker({
                format: 'DD-MM-YYYY',
                date: '{!! old('test_at', $registrant->test_at ? $registrant->test_at->format('Y-m-d') : null) !!}',
                useCurrent: false,
                minDate: moment().format(),
                @if($registrant->admission->end_date)
                    maxDate: moment('{{ $registrant->admission->end_date->toDateString() }}').format(),
                @endif
                enabledDates: {!! $enabledDates !!}
            });
        })
    </script>
@endpush
