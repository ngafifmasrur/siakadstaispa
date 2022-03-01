@extends('admission::layouts.default')

@section('subtitle', 'Alamat e-mail - ')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-lg-8 offset-lg-2">
				<h2 class="mb-0"><a class="text-decoration-none small" href="{{ request('next', url()->previous()) }}"><i class="icon-arrow-left-circle"></i></a> Alamat e-mail</h2>
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="col-lg-8 offset-lg-2">
			    <p>Alamat e-mail berfungsi untuk menerima informasi yang Anda gunakan dengan akun ini, termasuk atur ulang sandi, menerima pemberitahuan, dan lain sebagainya.</p>
				<div class="card">
					<div class="card-body">
						<form class="form-block" action="{{ route('admission.form.email', ['next' => request('next')]) }}" method="POST"> @csrf @method('PUT')
							@include('admission::form.email.includes.form', ['registrant' => $registrant])
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection