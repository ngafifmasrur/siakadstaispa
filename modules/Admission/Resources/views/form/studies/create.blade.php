@extends('admission::layouts.default')

@section('subtitle', 'Tambah riwayat pendidikan - ')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-lg-8 offset-lg-2">
				<h2 class="mb-0"><a class="text-decoration-none small" href="{{ request('next', route('admission.form.studies.index')) }}"><i class="icon-arrow-left-circle"></i></a> Tambah riwayat pendidikan</h2>
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="col-lg-8 offset-lg-2">
			    <p>Riwayat pendidikan digunakan untuk kelengkapan administrasi.</p>
				<div class="card">
					<div class="card-body">
						<form class="form-block" action="{{ route('admission.form.studies.store', ['next' => request('next')]) }}" method="POST"> @csrf
							@include('admission::form.studies.includes.form-create', ['registrant' => $registrant])
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection