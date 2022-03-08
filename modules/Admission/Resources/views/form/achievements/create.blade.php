@extends('admission::layouts.default')

@section('subtitle', 'Tambah data prestasi - ')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-lg-8 offset-lg-2">
				<h2 class="mb-0"><a class="text-decoration-none small" href="{{ request('next', route('admission.form.achievements.index')) }}"><i class="icon-arrow-left-circle"></i></a> Tambah data prestasi</h2>
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="col-lg-8 offset-lg-2">
			    <p>Data prestasi digunakan untuk kelengkapan administrasi.</p>
				<div class="card">
					<div class="card-body">
						<form class="form-block" action="{{ route('admission.form.achievements.store', ['next' => request('next')]) }}" method="POST" enctype="multipart/form-data"> @csrf
							@include('admission::form.achievements.includes.form-create', ['registrant' => $registrant])
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection