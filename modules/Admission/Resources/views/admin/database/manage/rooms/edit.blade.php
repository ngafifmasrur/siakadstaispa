@extends('admission::admin.layouts.admin')

@section('subtitle', 'Data kamar - ')

@section('breadcrumb')
    <li class="breadcrumb-item">Pangkalan data</li>
    <li class="breadcrumb-item">Kelola</li>
    <li class="breadcrumb-item"><a href="{{ route('admission.admin.database.manage.rooms.index') }}">Data kamar</a></li>
    <li class="breadcrumb-item active">Data kamar</li>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2 class="mb-0"><a class="text-decoration-none small" href="{{ request('next', url()->previous()) }}"><i class="mdi mdi-arrow-left-circle"></i></a> Ubah data kamar</h2>
            <hr>
            <div class="card">
                <div class="card-body">
                    <form class="form-block" action="{{ route('admission.admin.database.manage.rooms.update', ['room' => $room->id, 'next' => request('next', url()->previous()) ]) }}" method="POST"> @csrf @method('PUT')
                        <fieldset>
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">Area</label>
                                <div class="col-md-7">
                                    <input type="text" class="form-control-plaintext" value="{{ $room->sex_name }}" readonly>
                                </div>
                            </div>
                            <div class="form-group required row">
                                <label class="col-md-4 col-form-label text-md-right">Nama kamar</label>
                                <div class="col-md-7">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror " name="name" value="{{ old('name', $room->name) }}" required autofocus>
                                    @error('name')
                                        <span class="invalid-feedback"> {{ $message }} </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group required row">
                                <label class="col-md-4 col-form-label text-md-right">Kapasitas/kuota</label>
                                <div class="col-md-3">
                                    <input type="number" class="form-control @error('quota') is-invalid @enderror " name="quota" value="{{ old('quota', $room->quota) }}" min="0" max="100" required>
                                    @error('quota')
                                        <span class="invalid-feedback"> {{ $message }} </span>
                                    @enderror
                                </div>
                            </div>
                        </fieldset>
                        <hr>
                        <div class="form-group row mb-0">
                            <div class="col-md-7 offset-md-4">
                                <button class="btn btn-success" type="submit">Simpan</button>
                                <a class="btn btn-secondary" href="{{ request('next', url()->previous()) }}">Kembali</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection