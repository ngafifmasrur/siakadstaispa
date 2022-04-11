@extends('admission::admin.layouts.admin')

@section('subtitle', 'Tanggal Kedatangan - ')

@section('breadcrumb')
	<li class="breadcrumb-item">Pangkalan data</li>
	<li class="breadcrumb-item">Kelola</li>
    <li class="breadcrumb-item"><a href="{{ route('admission.admin.database.manage.registrants.index') }}">Calon mahasiswa baru</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admission.admin.database.manage.registrants.show', ['registrant' => $registrant->id]) }}">{{ $registrant->kd }}</a></li>
    <li class="breadcrumb-item active">Tanggal Kedatangan</li>
@endsection

@section('content')
    <h2 class="mb-0"><a class="text-decoration-none small" href="{{ request('next', url()->previous()) }}"><i class="mdi mdi-arrow-left-circle"></i></a> Ubah alamat e-mail</h2>
    <hr>
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form class="form-block" action="{{ route('admission.admin.database.manage.registrants.update', ['registrant' => $registrant->id, 'uid' => $registrant->user_id, 'key' => request('key'), 'next' => request('next')]) }}" method="POST" enctype="multipart/form-data">
                        @csrf @method('PUT')
                        @include('admission::form.tanggal_kedatangan.includes.form', ['registrant' => $registrant])
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            @include('admission::includes.registrant-information', ['registrant' => $registrant])
        </div>
    </div>
@endsection