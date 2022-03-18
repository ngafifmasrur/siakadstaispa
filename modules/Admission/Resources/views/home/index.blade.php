@extends('admission::layouts.default')

@section('subtitle', 'Data pendaftaran - ')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-8">
				<div class="jumbotron bg-dark text-white">
					<h1>Assalamualaikum {{ $registrant->user->profile->full_name }}!</h1>
					<div>di {{ config('admission.head.title') }}</div>
				</div> 
				{{-- @include('admission::includes.announcements') --}}
				@include('admission::includes.registrant-form-status', ['registrant' => $registrant])
				@include('admission::includes.registrant-progress', ['registrant' => $registrant])
				@include('admission::includes.registrant-cbt', ['registrant' => $registrant])
			</div>
			<div class="col-md-4">
				@include('admission::includes.registrant-information', ['registrant' => $registrant])
				{{-- @include('admission::includes.registrant-test', ['registrant' => $registrant]) --}}
				@if ($registrant->is_saman == 1)
				<div class="card">
					<div class="card-body">
						<h5 class="mb-4">Jadwal Wawancara</h5>
						<ul class="list-unstyled mb-0">
								<li class="mb-2">
									<span class="font-weight-bold">Waktu: {{ $registrant->jadwal_wawancara ?? 'Belum ada' }}</span> <br>
								</li>
								<li class="mb-2">
									<span class="font-weight-bold">Jenis: {{ strtoupper($registrant->jenis_wawancara) ?? '-' }}</span> <br>
								</li>
						</ul>
					</div>
				</div>
				@endif

				@include('admission::includes.menu')
			</div>
		</div>
	</div>
@endsection