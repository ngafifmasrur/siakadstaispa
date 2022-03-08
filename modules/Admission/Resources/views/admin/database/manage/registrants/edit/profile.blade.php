@extends('admission::admin.layouts.admin')

@section('subtitle', 'Kelola calon mahasiswa baru - ')

@section('breadcrumb')
	<li class="breadcrumb-item">Pangkalan data</li>
	<li class="breadcrumb-item">Kelola</li>
    <li class="breadcrumb-item"><a href="{{ route('admission.admin.database.manage.registrants.index') }}">Calon mahasiswa baru</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admission.admin.database.manage.registrants.show', ['registrant' => $registrant->id]) }}">{{ $registrant->kd }}</a></li>
    <li class="breadcrumb-item active">Data diri</li>
@endsection

@section('content')
    <h2 class="mb-0"><a class="text-decoration-none small" href="{{ request('next', url()->previous()) }}"><i class="mdi mdi-arrow-left-circle"></i></a> Ubah data diri</h2>
    <hr>
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form class="form-block" action="{{ route('admission.admin.database.manage.registrants.update', ['registrant' => $registrant->id, 'uid' => $registrant->user_id, 'key' => request('key'), 'next' => request('next')]) }}" method="POST" enctype="multipart/form-data"> @csrf @method('PUT')
                        @include('admission::form.profile.includes.form', ['registrant' => $registrant])
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            @include('admission::includes.registrant-information', ['registrant' => $registrant])
        </div>
    </div>
@endsection