@extends('admission::admin.layouts.admin')

@section('subtitle', 'Data Tahun Akademik - ')

@section('breadcrumb')
    <li class="breadcrumb-item">Pangkalan data</li>
    <li class="breadcrumb-item">Kelola</li>
    <li class="breadcrumb-item">
        <a href="{{ route('admission.admin.database.manage.periode.index') }}">
            Data Tahun Akademik
        </a>
    </li>
    <li class="breadcrumb-item active">Data Tahun Akademik</li>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2 class="mb-0">
                <a class="text-decoration-none small" href="{{ request('next', route('admission.admin.database.manage.periode.index')) }}">
                <i class="mdi mdi-arrow-left-circle"></i></a> Tambah data tahun akademik
            </h2>
            <hr>
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admission.admin.database.manage.periode.store', [
                            'next' => request('next', url()->previous())
                        ]) }}" class="form-block" method="POST">
                        @csrf
                            <div class="form-group required row">
                                <label class="col-md-4 col-form-label text-md-right">Nama</label>
                                <div class="col-md-7">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror "
                                        name="name" value="{{ old('name') }}" required autofocus>
                                    @error('name')
                                        <span class="invalid-feedback"> {{ $message }} </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group required row">
                                <label class="col-md-4 col-form-label text-md-right">Tahun Akademik</label>
                                <div class="col-md-7">
                                    <input type="text" class="form-control @error('year') is-invalid @enderror "
                                        name="year" value="{{ old('year') }}" required autofocus id="datepicker">
                                    @error('year')
                                        <span class="invalid-feedback"> {{ $message }} </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group required row">
                                <label class="col-md-4 col-form-label text-md-right">Tanggal Buka Pendaftaran</label>
                                <div class="col-md-7">
                                    <input type="text" class="form-control @error('start_date') is-invalid @enderror "
                                        name="start_date" value="{{ old('start_date') }}" required autofocus>
                                    @error('start_date')
                                        <span class="invalid-feedback"> {{ $message }} </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group required row">
                                <label class="col-md-4 col-form-label text-md-right">Tanggal Tutup Pendaftaran</label>
                                <div class="col-md-7">
                                    <input type="text" class="form-control @error('end_date') is-invalid @enderror "
                                        name="end_date" value="{{ old('end_date') }}" required autofocus>
                                    @error('end_date')
                                        <span class="invalid-feedback"> {{ $message }} </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group required row">
                                <label class="col-md-4 col-form-label text-md-right">Status</label>
                                <div class="col-md-3">
                                    <select class="form-control" name="status" id="status">
                                        <option @if (old('status') == 1) selected @endif value="1">Aktif</option>
                                        <option @if (old('status') == 0) selected @endif value="0">Tidak Aktif</option>
                                    </select>
                                    @error('status')
                                        <span class="invalid-feedback"> {{ $message }} </span>
                                    @enderror
                                </div>
                            </div>
                        <hr>
                        <div class="form-group row mb-0">
                            <div class="col-md-7 offset-md-4">
                                <button class="btn btn-success" type="submit">Simpan</button>
                                <a class="btn btn-secondary" href="{{ request('next', route('admission.admin.database.manage.periode.index')) }}">Kembali</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('style')
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/css/datepicker.min.css" rel="stylesheet">
@endpush

@push('script')
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/js/bootstrap-datepicker.min.js"></script>
    <script>
    $(function() {
        $("#datepicker").datepicker({
            format: "yyyy",
            viewMode: "years",
            minViewMode: "years",
            autoclose:true
        });

        $("input[name='start_date'],input[name='end_date']").datepicker({
            autoclose:true,
            format: "yyyy-m-dd",
        });
    });
</script>
@endpush
