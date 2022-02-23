@extends('layouts.app')
@section('title', 'Dosen Wali')

@section('content')
<x-header>
    Dosen Wali
</x-header>
<!-- Main page content-->

<x-card-info>
    @if (isset($dosen))
        <x-slot name="title">Dosen Wali: {{ $dosen->nama_dosen }}</x-slot>
        <table cellpadding="4" cellspacing="2">
            <tr>
                <td class="font-weight-bold">NIDN Dosen Wali</td>
                <td>:</td>
                <td>{{ $dosen->nidn }}</td>
            </tr>
            <tr>
                <td class="font-weight-bold">Nama Dosen Wali</td>
                <td>:</td>
                <td>{{ $dosen->nama_dosen }}</td>
            </tr>
        </table>
    @endif
</x-card-info>

<x-card-table>
    <x-slot name="title">Pilih / Ganti Dosen Wali</x-slot>
    <form action="{{ route('mahasiswa.dosen_wali.store')}}" method="post" id="form_setting">
        @csrf
            <div class="tabs-menu1 ">
                <ul class="nav panel-tabs" id="cardTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="identitas-tab" href="#identitas" data-toggle="tab" role="tab" aria-controls="overview" aria-selected="true">Dosen Wali</a>
                    </li>
                </ul>
            </div>
            
            <div class="card-body">
                <div class="tab-content" id="cardTabContent">
                    <div class="tab-pane fade show active" id="identitas" role="tabpanel" aria-labelledby="overview-tab">
                        <div class="form-group">
                            <label for="dosen">Dosen</label>
                            {!! Form::select('id_dosen', $list_dosen, null, ['class' => 'form-control', 'id' => 'id_dosen']) !!}
                        </div>
                    </div>
                </div>
            </div>

            <button class="float-right btn btn-primary" type="submit">Simpan</button>
    </form>
</x-card-table>
@endsection