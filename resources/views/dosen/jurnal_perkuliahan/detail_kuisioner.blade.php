@extends('layouts.app')
@section('title', 'Detail Kuisioner')

@section('content')
<x-header>
    Detail Kuisioner
</x-header>
<x-card-table>
    <x-slot name="title">Detail Kuisioner</x-slot>
    
    <x-datatable 
    :route="route('dosen.kuisioner.dataDetail',$id)" 
    :table="[
        ['title' => 'No.', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => 'false', 'searchable' => 'false', 'width' => '10'],
        ['title' => 'Kuesioner', 'data' => 'kuesioner', 'name' => 'kuesioner', 'classname' => 'text-center'],
        ['title' => 'Jawaban', 'data' => 'jawaban', 'name' => 'jawaban', 'classname' => 'text-center'],
        ['title' => 'Skor', 'data' => 'skor', 'name' => 'skor'],
    ]"
    />
</x-card-table>

@endsection
