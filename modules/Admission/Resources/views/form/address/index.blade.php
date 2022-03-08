@extends('admission::layouts.default')

@section('subtitle', 'Alamat asal - ')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-lg-8 offset-lg-2">
				<h2 class="mb-0"><a class="text-decoration-none small" href="{{ request('next', url()->previous()) }}"><i class="icon-arrow-left-circle"></i></a> Alamat asal</h2>
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="col-lg-8 offset-lg-2">
			    <p>Data alamat asal digunakan untuk kelengkapan administrasi.</p>
				<div class="card">
					<div class="card-body">
						<form class="form-block" action="{{ route('admission.form.address', ['next' => request('next')]) }}" method="POST"> @csrf @method('PUT')
							@include('admission::form.address.includes.form', ['registrant' => $registrant])
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection