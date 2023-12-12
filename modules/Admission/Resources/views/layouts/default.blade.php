@extends('layouts.default')

@section('title' )@yield('subtitle') {{ config('admission.head.title') }}@endsection

@section('bodyclass', 'd-flex flex-column vh-100')

@section('main')
	<div style="flex: 1 0 auto;">
		@yield('navbar', view('admission::layouts.includes.navbar'))
		@if(session()->has('success'))
			<div class="container">
				<div class="alert alert-success alert-dismissible">
					<div class="container">
						<button class="close" data-dismiss="alert">&times;</button>
						{!! session('success') !!}
					</div>
				</div>
			</div>
		@endif
		@if(session()->has('danger'))
			<div class="container">
				<div class="alert alert-danger alert-dismissible">
					<div class="container">
						<button class="close" data-dismiss="alert">&times;</button>
						{!! session('danger') !!}
					</div>
				</div>
			</div>
		@endif
		@yield('content')
	</div>
	<footer class="app-footer border-light text-muted">
        <div class="container py-4 flex-shrink-0">
            @include('admission::layouts.includes.footer')
        </div>
	</footer>
	@include('account::includes.logout', ['next' => route('admission.index')])
@endsection
