@extends('admission::admin.layouts.admin')

@section('subtitle', 'Kelola calon mahasiswa baru - ')

@section('breadcrumb')
	<li class="breadcrumb-item">Pangkalan data</li>
	<li class="breadcrumb-item">Kelola</li>
    <li class="breadcrumb-item"><a href="{{ route('admission.admin.database.manage.registrants.index') }}">Calon mahasiswa baru</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admission.admin.database.manage.registrants.show', ['registrant' => $registrant->id]) }}">{{ $registrant->kd }}</a></li>
    <li class="breadcrumb-item active">Pemilihan tanggal tes</li>
@endsection

@section('content')
    <h2 class="mb-0"><a class="text-decoration-none small" href="{{ request('next', url()->previous()) }}"><i class="mdi mdi-arrow-left-circle"></i></a> Pemilihan tanggal tes</h2>
    <hr>
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form class="form-block" action="{{ route('admission.admin.database.manage.registrants.update', ['registrant' => $registrant->id, 'uid' => $registrant->user_id, 'key' => request('key'), 'next' => request('next')]) }}" method="POST"> @csrf @method('PUT')
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
                                    <small class="form-text text-muted">Pilih tanggal tes di lokasi pendaftaran</small>
                                    @error('test_at')
                                        <span class="invalid-feedback">{{ $message }} </span> 
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group required row">
                                <label class="col-md-4 col-form-label text-md-right">Sesi tes</label>
                                <div class="col-md-8">
                                    <select class="js-example-basic-single form-control{{ $errors->has('session') ? ' is-invalid' : '' }}" name="session" required>
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
                                <a class="btn btn-secondary" href="{{ request('next', url()->previous()) }}">Kembali</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            @include('admission::includes.registrant-information', ['registrant' => $registrant])
        </div>
    </div>
@endsection

@push('script')
    <script type="text/javascript">
        $(function () {
            $('#test_at').datetimepicker({
                format: 'DD-MM-Y',
                date: '{!! old('test_at', $registrant->test_at ? $registrant->test_at->format('Y-m-d') : null) !!}',
                useCurrent: false,
                minDate: moment().format(),
                @if($registrant->admission->end_date)
                    maxDate: moment('{{ $registrant->admission->end_date->toDateString() }}').format(),
                @endif
                enabledDates: {!! $registrant->admission->testDates->where('date', '>=', date('Y-m-d'))->take(6)->pluck('date') !!}
            });
        })
    </script>
@endpush
