@extends('layouts.default')

@section('title')@yield('subtitle'){{ config('web.head.title') }}@endsection

@section('main')
    @yield('content')
@endsection
