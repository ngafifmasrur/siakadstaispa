@extends('admission::admin.layouts.admin')

@section('subtitle', 'Jadwal Wawancara - ')

@section('breadcrumb')
	<li class="breadcrumb-item">Pendaftaran</li>
    <li class="breadcrumb-item"><a href="{{ route('admission.admin.registration.saman.index') }}">Pilih SAMAN</a></li>
    <li class="breadcrumb-item active">Jadwal Wawancara</li>
@endsection

@section('section')
	<div class="section">
	    <h3 class="mb-1">Jadwal Wawancara</h3>
	    <div class="mb-2">Kelola jadwal wawancara untuk SAMAN.</div>
	</div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-4">
            @include('admission::includes.registrant-information', ['registrant' => $registrant, 'simple' => true])
        </div>
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-body">
                    <span class="btn btn-primary mb-3">Jadwal Wawancara: {{  $registrant->jadwal_wawancara ?? 'Belum diset' }}</span>
                    <form class="form-block" action="{{ route('admission.admin.registration.saman.set_jadwal_wawancara', ['registrant' => $registrant->id]) }}" method="POST"> @csrf @method('PUT')
                        <div class="form-group">
                            <label class="form-control-label">Edit/Input Jadwal Wawancara</label>
                            <input type="datetime-local" class="form-control{{ $errors->has('tanggal_wawancara') ? ' is-invalid' : '' }}" name="tanggal_wawancara" id="tanggal_wawancara" value="{{ $registrant->jadwal_wawancara }}">
                            @if ($errors->has('pass'))
                                <span class="invalid-feedback"> {{ $errors->first('tanggal_wawancara') }} </span>
                            @endif
                        </div>
                        <div class="form-group mb-0">
                            <button type="submit" class="btn btn-success"><i class="mdi mdi-check"></i> Simpan</button>
                        </div>
                    </form>
            </div>
        </div>
    </div>
@endsection