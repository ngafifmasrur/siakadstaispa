@extends('account::layouts.auth')

@section('subtitle', 'Akun saya - ')
@section('card-title', 'Akun saya')

@php
$user = auth()->user();
@endphp

@section('content')
    <h4>Selamat datang!</h4>
    <p class="text-muted">Halaman ini hanya menampilkan informasi akun Anda yang telah masuk di perangkat ini.</p>
    <p>
    	Nama lengkap <br>
    	<strong>{{ $user->profile->name ?? '-' }}</strong>
    </p>
    <p>
    	Username <br>
    	<strong>{{ $user->full_username }}</strong>
    </p>
    <hr>
    @component('account::includes.logout')
    	<a class="btn btn-success" href="{{ route('account.user.password', ['next' => url()->current()]) }}">Ubah sandi</a>
        <button class="btn btn-secondary">Logout</button>
    @endcomponent
@endsection