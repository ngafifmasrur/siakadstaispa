@extends('admission::admin.layouts.admin')

@section('subtitle', 'Edit Mapel CBT - ')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admission.admin.cbt.index') }}">CBT</a></li>
    <li class="breadcrumb-item active">Edit Mapel CBT</li>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2 class="mb-0"><a class="text-decoration-none small" href="{{ request('next', url()->previous()) }}"><i class="mdi mdi-arrow-left-circle"></i></a> Ubah data mapel</h2>
            <hr>
            <div class="card">
                <div class="card-body">
                    <form class="form-block" action="{{ route('admission.admin.cbt.update', ['cbt' => $cbt->id, 'next' => request('next', url()->previous()) ]) }}" method="POST"> @csrf @method('PUT')
                        <fieldset>
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">Periode</label>
                                <div class="col-md-7">
                                    <select class="form-control" name="admission_id" id="admission_id">
                                        @foreach ($admission as $item)
                                            <option @if ($cbt->admission_id == $item->id) selected @endif value="{{ $item->id }}">{{ $item->period->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">Kode Mapel</label>
                                <div class="col-md-7">
                                    <input class="form-control" type="text" name="kode_mapel" id="kode_mapel" value="{{ $cbt->kode_mapel }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">Nama Mapel</label>
                                <div class="col-md-7">
                                    <input class="form-control" type="text" name="mapel" id="mapel" value="{{ $cbt->mapel }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">Deskripsi</label>
                                <div class="col-md-7">
                                    <input class="form-control" type="text" name="description" id="description" value="{{ $cbt->description }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">Durasi (dalam menit)</label>
                                <div class="col-md-7">
                                    <input class="form-control" type="text" name="durasi" id="durasi" placeholder="60" value="{{ $cbt->durasi }}>
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