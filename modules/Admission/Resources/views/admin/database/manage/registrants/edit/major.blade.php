@extends('admission::admin.layouts.admin')

@section('subtitle', 'Kelola calon mahasiswa baru - ')

@section('breadcrumb')
	<li class="breadcrumb-item">Pangkalan data</li>
	<li class="breadcrumb-item">Kelola</li>
    <li class="breadcrumb-item"><a href="{{ route('admission.admin.database.manage.registrants.index') }}">Calon mahasiswa baru</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admission.admin.database.manage.registrants.show', ['registrant' => $registrant->id]) }}">{{ $registrant->kd }}</a></li>
    <li class="breadcrumb-item active">Pemilihan progarm studi</li>
@endsection

@section('content')
    <h2 class="mb-0"><a class="text-decoration-none small" href="{{ request('next', url()->previous()) }}"><i class="mdi mdi-arrow-left-circle"></i></a> Pemilihan program studi</h2>
    <hr>
    <div class="row">
        <div class="col-md-8">
            <p>Tentukan 2 pilihan program studi yang akan Anda masuki.</p>
            <div class="card">
                <div class="card-body">
                    <h5 class="mb-0">Pemilihan program studi</h5>
                </div>
                <div class="card-body border-top">
                    <form class="form-block" action="{{ route('admission.admin.database.manage.registrants.update', ['registrant' => $registrant->id, 'uid' => $registrant->user_id, 'key' => request('key'), 'next' => request('next')]) }}" method="POST"> @csrf @method('PUT')
                        <fieldset>
                            <div class="form-group required row">
                                <label class="col-md-4 col-form-label text-md-right">Pilihan 1</label>
                                <div class="col-md-8">
                                    <select class="form-control @error('major1') is-invalid @enderror" name="major1" required>
                                        <option value="">-- Pilih --</option>
                                        @foreach($majors as $id => $major)
                                            <option value="{{ $id }}" @if($id == old('major1', $registrant->major1 ?? -1)) selected @endif>{{ $major }}</option>
                                        @endforeach
                                    </select>
                                    @error('major1')
                                        <span class="invalid-feedback">{{ $message }} </span> 
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group required row">
                                <label class="col-md-4 col-form-label text-md-right">Pilihan 2</label>
                                <div class="col-md-8">
                                    <select class="form-control @error('major2') is-invalid @enderror" name="major2" required>
                                        <option value="">-- Pilih --</option>
                                        @foreach($majors as $id => $major)
                                            <option value="{{ $id }}" @if($id == old('major2', $registrant->major2 ?? -1)) selected @endif>{{ $major }}</option>
                                        @endforeach
                                    </select>
                                    @error('major2')
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
                </div>      
            </div>
        </div>
        <div class="col-md-4">
            @include('admission::includes.registrant-information', ['registrant' => $registrant])
        </div>
    </div>
@endsection