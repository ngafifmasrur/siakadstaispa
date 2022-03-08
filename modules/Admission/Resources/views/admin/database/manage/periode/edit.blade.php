@extends('admission::admin.layouts.admin')

@section('subtitle', 'Data Periode Penerimaan - ')

@section('breadcrumb')
    <li class="breadcrumb-item">Periode Penerimaan</li>
    <li class="breadcrumb-item"><a href="{{ route('admission.admin.database.manage.periode.index') }}">Data Periode Penerimaan</a></li>
    <li class="breadcrumb-item active">Data Periode Penerimaan</li>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2 class="mb-0"><a class="text-decoration-none small" href="{{ request('next', url()->previous()) }}"><i class="mdi mdi-arrow-left-circle"></i></a> Ubah data periode</h2>
            <hr>
            <div class="card">
                <div class="card-body">
                    <form class="form-block" action="{{ route('admission.admin.database.manage.periode.update', ['periode' => $periode->id, 'next' => request('next', url()->previous()) ]) }}" method="POST"> @csrf @method('PUT')
                        <fieldset>
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">Nama</label>
                                <div class="col-md-7">
                                    <input class="form-control" type="text" name="name" id="name" value="{{ $periode->name }}" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">Tahun</label>
                                <div class="col-md-7">
                                    <input class="form-control" type="text" name="year" id="year" value="{{ $periode->period->year }}" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">Nama Periode</label>
                                <div class="col-md-7">
                                    <input class="form-control" type="text" name="name" id="name" value="{{ $periode->period->name }}" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">Status</label>
                                <div class="col-md-7">
                                    <select class="form-control" name="open" id="open">
                                        <option @if ($periode->open == 1) selected @endif value="1">Buka</option>
                                        <option @if ($periode->open == 0) selected @endif value="0">Tutup</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group required row">
                                <label class="col-md-4 col-form-label text-md-right">Status Publish</label>
                                <div class="col-md-7">
                                    <select class="form-control" name="published" id="published">
                                        <option @if ($periode->published == 1) selected @endif value="1">Published</option>
                                        <option @if ($periode->published == 0) selected @endif value="0">Unpublished</option>
                                    </select>
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