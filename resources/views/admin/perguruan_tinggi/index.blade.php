@extends('layouts.app')
@section('title', 'Perguruan Tinggi')

@section('content')
<header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
    <div class="container">
        <div class="page-header-content pt-4">
            <div class="row align-items-center justify-content-between">
                <div class="col-auto mt-4">
                    <h1 class="page-header-title">
                        <div class="page-header-icon"><i data-feather="grid"></i></div>
                        Perguruan Tinggi
                    </h1>
                    {{-- <div class="page-header-subtitle">Example dashboard overview and content summary</div> --}}
                </div>
            </div>
        </div>
    </div>
</header>
<!-- Main page content-->
<div class="container mt-n10">
    <div class="row">
        <div class="col-lg-12">
            <form action="" method="post">
                <div class="card">
                    <div class="card-header border-bottom align-items-center">
                        <ul class="nav nav-tabs card-header-tabs" id="cardTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="identitas-tab" href="#identitas" data-toggle="tab" role="tab" aria-controls="overview" aria-selected="true">Identitas</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="alamat-tab" href="#alamat" data-toggle="tab" role="tab" aria-controls="example" aria-selected="false">Alamat</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pengesahan-tab" href="#pengesahan" data-toggle="tab" role="tab" aria-controls="example" aria-selected="false">Pengesahan</a>
                            </li>
                            <li class="nav-item ml-auto">
                                <button type="submit" class="float-right btn btn-primary btn-sm">Simpan</button>
                            </li>

                        </ul>

                    </div>
                    
                    <div class="card-body">
                        <div class="tab-content" id="cardTabContent">
                            <div class="tab-pane fade show active" id="identitas" role="tabpanel" aria-labelledby="overview-tab">
                                <h5 class="card-title">Identitas</h5>
                                <div class="form-group">
                                    <label for="kode_perguruan_tinggi">Kode Perguruan Tinggi</label>
                                    <input class="form-control" name="kode_perguruan_tinggi" id="kode_perguruan_tinggi" type="text">
                                </div>
                                <div class="form-group">
                                    <label for="nama_perguruan_tinggi">Nama Perguruan Tinggi</label>
                                    <input class="form-control" name="nama_perguruan_tinggi" id="nama_perguruan_tinggi" type="text">
                                </div>
                            </div>
                            <div class="tab-pane fade show" id="alamat" role="tabpanel" aria-labelledby="alamat-tab">
                                <h5 class="card-title">Alamat</h5>
                                <div class="form-group">
                                    <label for="jalan">Jalan</label>
                                    <textarea class="form-control" name="jalan" id="jalan" cols="30" rows="5"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="rt_rw">RT/RW</label>
                                    <input class="form-control" name="rt_rw" id="rt_rw" type="text">
                                </div>
                                <div class="form-group">
                                    <label for="kelurahan">Kelurahan</label>
                                    <input class="form-control" name="kelurahan" id="kelurahan" type="text">
                                </div>
                                <div class="form-group">
                                    <label for="faximile">Kode Pos</label>
                                    <input class="form-control" name="kode_pos" id="kode_pos" type="text">
                                </div>
                                <div class="form-group">
                                    <label for="lintang_bujur">Lintang Bujur</label>
                                    <input class="form-control" name="lintang_bujur" id="lintang_bujur" type="text">
                                </div>
                                <div class="form-group">
                                    <label for="telepon">Telepon</label>
                                    <input class="form-control" name="telepon" id="telepon" type="text">
                                </div>
                                <div class="form-group">
                                    <label for="faximile">Faximile</label>
                                    <input class="form-control" name="faximile" id="faximile" type="text">
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input class="form-control" name="email" id="email" type="email">
                                </div>
                                <div class="form-group">
                                    <label for="website">Website</label>
                                    <input class="form-control" name="website" id="website" type="text">
                                </div>
                            </div>
                            <div class="tab-pane fade show" id="pengesahan" role="tabpanel" aria-labelledby="pengesahan-tab">
                                <h5 class="card-title">Pengesahan</h5>
                                <div class="form-group">
                                    <label for="sk_pendirian">SK Pendirian</label>
                                    <input class="form-control" name="lintang_bujur" id="lintang_bujur" type="text">
                                </div>
                                <div class="form-group">
                                    <label for="tanggal_sk_pendirian">Tanggal SK Pendirian</label>
                                    <input class="form-control" name="tanggal_sk_pendirian" id="tanggal_sk_pendirian" type="date">
                                </div>
                                <div class="form-group">
                                    <label for="kelurahan">SK Izin Operasional</label>
                                    <input class="form-control" name="sk_izin_operasional" id="sk_izin_operasional" type="text">
                                </div>
                                <div class="form-group">
                                    <label for="faximile">Tanggal Izin Operasional</label>
                                    <input class="form-control" name="tanggal_izin_operasional" id="tanggal_izin_operasional" type="date">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection