@extends('layouts.app')
@section('title', 'KRS')

@section('content')

<x-header>
    KRS
</x-header>

<x-card-table>
    <x-slot name="title">Mahasiswa tidak memiliki semester aktif</x-slot>
</x-card-table>

@endsection