@extends('layouts.app')
@section('title', 'Perguruan Tinggi')

@section('content')
<x-header>
    Perguruan Tinggi
</x-header>
<!-- Main page content-->
<x-card-table>
    <x-slot name="title">Perguruan Tinggi</x-slot>
    <x-slot name="button">
        <button class="btn btn-app btn-sm btn-primary" onclick="document.getElementById('form_pt').submit();" href="#"><i class="fa fa-save mr-2"></i>Simpan</button>
    </x-slot>

    <form action="{{ route('admin.perguruan_tinggi.update')}}" method="post" id="form_pt">
        @csrf
            <div class="tabs-menu1 ">
                <ul class="nav panel-tabs" id="cardTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="identitas-tab" href="#identitas" data-toggle="tab" role="tab" aria-controls="overview" aria-selected="true">Identitas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="alamat-tab" href="#alamat" data-toggle="tab" role="tab" aria-controls="example" aria-selected="false">Alamat</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pengesahan-tab" href="#pengesahan" data-toggle="tab" role="tab" aria-controls="example" aria-selected="false">Pengesahan</a>
                    </li>

                </ul>
            </div>
            
            <div class="card-body">
                <div class="tab-content" id="cardTabContent">
                    <div class="tab-pane fade show active" id="identitas" role="tabpanel" aria-labelledby="overview-tab">
                        <h5 class="card-title">Identitas</h5>
                        <div class="form-group">
                            <label for="kode_perguruan_tinggi">Kode Perguruan Tinggi</label>
                            <input class="form-control" name="kode_perguruan_tinggi" id="kode_perguruan_tinggi" value="{{ isset($data) ? $data->kode_perguruan_tinggi : ''}}" type="text">
                        </div>
                        <div class="form-group">
                            <label for="nama_perguruan_tinggi">Nama Perguruan Tinggi</label>
                            <input class="form-control" name="nama_perguruan_tinggi" id="nama_perguruan_tinggi" value="{{ isset($data) ? $data->nama_perguruan_tinggi : ''}}" type="text">
                        </div>
                    </div>
                    <div class="tab-pane fade show" id="alamat" role="tabpanel" aria-labelledby="alamat-tab">
                        <h5 class="card-title">Alamat</h5>
                        <div class="form-group">
                            <label for="jalan">Jalan</label>
                            <textarea class="form-control" name="jalan" id="jalan" cols="30" rows="5">{{ isset($data) ? $data->jalan : ''}}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="rt_rw">RT/RW</label>
                            <input class="form-control" name="rt_rw" id="rt_rw" value="{{ isset($data) ? $data->rt_rw : ''}}" type="text">
                        </div>
                        <div class="form-group">
                            <label for="kelurahan">Kelurahan</label>
                            <input class="form-control" name="kelurahan" id="kelurahan" type="text" value="{{ isset($data) ? $data->kelurahan : ''}}">
                        </div>
                        <div class="form-group">
                            <label for="faximile">Kode Pos</label>
                            <input class="form-control" name="kode_pos" id="kode_pos" value=" {{ isset($data) ? $data->kode_pos : ''}}" type="text">
                        </div>
                        <div class="form-group">
                            <label for="lintang_bujur">Lintang Bujur</label>
                            <input class="form-control" name="lintang_bujur" id="lintang_bujur" value="{{ isset($data) ? $data->kelurahan : ''}}" type="text">
                        </div>
                        <div class="form-group">
                            <label for="telepon">Telepon</label>
                            <input class="form-control" name="telepon" id="telepon" value="{{ isset($data) ? $data->telepon : ''}}" type="text">
                        </div>
                        <div class="form-group">
                            <label for="faximile">Faximile</label>
                            <input class="form-control" name="faximile" id="faximile" value="{{ isset($data) ? $data->faximile : ''}}" type="text">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input class="form-control" name="email" id="email" value="{{ isset($data) ? $data->email : ''}}" type="email">
                        </div>
                        <div class="form-group">
                            <label for="website">Website</label>
                            <input class="form-control" name="website" id="website" value="{{ isset($data) ? $data->website : ''}}" type="text">
                        </div>
                    </div>
                    <div class="tab-pane fade show" id="pengesahan" role="tabpanel" aria-labelledby="pengesahan-tab">
                        <h5 class="card-title">Pengesahan</h5>
                        <div class="form-group">
                            <label for="sk_pendirian">SK Pendirian</label>
                            <input class="form-control" name="lintang_bujur" id="lintang_bujur" value="{{ isset($data) ? $data->lintang_bujur : ''}}" type="text">
                        </div>
                        <div class="form-group">
                            <label for="tanggal_sk_pendirian">Tanggal SK Pendirian</label>
                            <input class="form-control" name="tanggal_sk_pendirian" id="tanggal_sk_pendirian" value="{{ isset($data) ? $data->tanggal_sk_pendirian : ''}}" type="date">
                        </div>
                        <div class="form-group">
                            <label for="kelurahan">SK Izin Operasional</label>
                            <input class="form-control" name="sk_izin_operasional" id="sk_izin_operasional" value="{{ isset($data) ? $data->sk_izin_operasional : ''}}" type="text">
                        </div>
                        <div class="form-group">
                            <label for="faximile">Tanggal Izin Operasional</label>
                            <input class="form-control" name="tanggal_izin_operasional" id="tanggal_izin_operasional" value="{{ isset($data) ? $data->tanggal_izin_operasional : ''}}" type="date">
                        </div>
                    </div>
                </div>
            </div>
    </form>
</x-card-table>
@endsection