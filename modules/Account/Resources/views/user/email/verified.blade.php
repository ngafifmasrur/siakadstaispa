@extends('layouts.simple')

@section('subtitle', 'Email terverifikasi ')

@section('main')
<div class="center">
	<h2>Email terverifikasi</h2>
	<p>Terimakasih telah memverifikasi alamat e-mail Anda {{ $email->address }}</p>
	<p><button class="btn btn-success" style="border: none;" onclick="window.close()">Tutup halaman ini</button></p>
</div>
@endsection
