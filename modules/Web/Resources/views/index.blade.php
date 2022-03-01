@extends('web::layouts.default')

@section('content')
    <div class="jumbotron" style="background: url('{{ asset('assets/img/web.jpg') }}') no-repeat no-repeat center; background-size: cover;">
    	<div class="container my-5 py-5">
    		<h1 class="font-weight-bold">Mata CendeQia</h1>
    		<p>Mandiri, Berprestasi, Cerdas dan Berkepribadian Qur'ani.</p>
    		<a class="btn btn-outline-success btn-pill" href="{{ route('admission.index') }}">Bergabung bersama kami &raquo;</a>
    	</div>
    </div>
@endsection
