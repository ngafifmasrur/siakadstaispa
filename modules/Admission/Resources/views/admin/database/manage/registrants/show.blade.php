@extends('admission::admin.layouts.admin')

@section('subtitle', 'Kelola calon mahasiswa baru - ')

@section('breadcrumb')
	<li class="breadcrumb-item">Pangkalan data</li>
	<li class="breadcrumb-item">Kelola</li>
    <li class="breadcrumb-item"><a href="{{ route('admission.admin.database.manage.registrants.index') }}">Calon mahasiswa baru</a></li>
    <li class="breadcrumb-item active">{{ $registrant->kd }}</li>
@endsection

@section('content')
    <h2 class="mb-0">
        <a class="text-decoration-none small" href="{{ request('next', route('admission.admin.database.manage.registrants.index')) }}"><i class="mdi mdi-arrow-left-circle"></i></a> Lihat detail
    </h2>
    <hr>
    <div class="row">
        <div class="col-md-8">
            @include('admission::includes.registrant-card', ['registrant' => $registrant])
            @include('admission::includes.registrant-form-status', ['registrant' => $registrant])
            @include('admission::includes.registrant-progress', ['registrant' => $registrant])
        </div>
        <div class="col-md-4">
            @include('admission::includes.registrant-information', ['registrant' => $registrant])
            @include('admission::includes.registrant-test', ['registrant' => $registrant])
        </div>
    </div>
@endsection