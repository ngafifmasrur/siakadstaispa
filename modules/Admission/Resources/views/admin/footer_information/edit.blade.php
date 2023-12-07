@extends('admission::admin.layouts.admin')

@section('subtitle', 'Edit Informasi Footer - ')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admission.admin.footer_information.index') }}">Informasi Footer</a></li>
    <li class="breadcrumb-item active">Edit Informasi Footer</li>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2 class="mb-0"><a class="text-decoration-none small" href="{{ request('next', url()->previous()) }}"><i class="mdi mdi-arrow-left-circle"></i></a> Ubah data Informasi Footer</h2>
            <hr>
            <div class="card">
                <div class="card-body">
                    <form class="form-block" action="{{ route('admission.admin.footer_information.update', ['footerInformation' => $footerInformation->id, 'next' => request('next', url()->previous()) ]) }}" method="POST" enctype="multipart/form-data"> @csrf @method('PUT')
                        <fieldset>
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">Type</label>
                                <div class="col-md-7">
                                    <select class="form-control" name="type" id="type">
                                        @foreach ($type as $key => $item)
                                            <option @if ($footerInformation->type == $item) selected @endif value="{{ $item }}">{{ $item }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">Nama</label>
                                <div class="col-md-7">
                                    <input class="form-control" type="text" name="name" id="name" value="{{ $footerInformation->name }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">Status</label>
                                <div class="col-md-7">
                                    <select class="form-control" name="status" id="status">
                                        <option @if ($footerInformation->status == 1) selected @endif value="1">Aktif</option>
                                        <option @if ($footerInformation->status == 0) selected @endif value="0">Tidak Aktif</option>
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
