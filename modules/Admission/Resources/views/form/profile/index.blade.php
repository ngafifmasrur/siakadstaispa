@extends('admission::layouts.default')

@section('subtitle', 'Data diri - ')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-lg-8 offset-lg-2">
				<h2 class="mb-0"><a class="text-decoration-none small" href="{{ request('next', url()->previous()) }}"><i class="icon-arrow-left-circle"></i></a> Data diri</h2>
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="col-lg-8 offset-lg-2">
			    <p>Beberapa informasi mungkin terlihat oleh publik seperti nama lengkap dan tempat lahir Anda.</p>
				<div class="card">
					<div class="card-body">
						<form class="form-block" action="{{ route('admission.form.profile', ['next' => request('next')]) }}" method="POST" enctype="multipart/form-data"> @csrf @method('PUT')
							@include('admission::form.profile.includes.form', ['registrant' => $registrant])
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection