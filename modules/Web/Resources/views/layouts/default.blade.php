@extends('layouts.default')

@section('title')@yield('subtitle'){{ config('web.head.title') }}@endsection

@section('main')
	@include('web::layouts.includes.navbar')
	@if(session()->has('success'))
		<div class="alert alert-success alert-dismissible rounded-0">
			<div class="container">
				<button class="close" data-dismiss="alert">&times;</button>
				{!! session('success') !!}
			</div>
		</div>
	@endif
    @yield('content')
@endsection
