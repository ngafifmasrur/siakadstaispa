@extends('layouts.app')
@section('title', 'Error')

@section('content')

<x-header>
    {!! Session::get('error_msg') !!}
</x-header>

<x-card-table>
    <x-slot name="title">{!! Session::get('error_msg') !!}</x-slot>
</x-card-table>

@endsection