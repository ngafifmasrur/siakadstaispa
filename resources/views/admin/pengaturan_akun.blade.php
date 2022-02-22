@extends('layouts.app')
@section('title', 'Pengaturan Akun')

@section('content')
<x-header>
    Pengaturan Akun
</x-header>
<!-- Main page content-->
<x-card-table>
    <x-slot name="title">Pengaturan Akun</x-slot>
    

    <form action="{{ route('admin.ganti_password')}}" method="post" id="form_setting">
        @csrf
            <div class="tabs-menu1 ">
                <ul class="nav panel-tabs" id="cardTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="identitas-tab" href="#identitas" data-toggle="tab" role="tab" aria-controls="overview" aria-selected="true">Ganti Password</a>
                    </li>
                </ul>
            </div>
            
            <div class="card-body">
                <div class="tab-content" id="cardTabContent">
                    <div class="tab-pane fade show active" id="identitas" role="tabpanel" aria-labelledby="overview-tab">
                        <h5 class="card-title">Ganti Password</h5>
                        <div class="form-group">
                            <label for="old_password">Password Lama</label>
                            <input class="form-control" name="old_password" id="old_password" type="password">
                        </div>
                        <div class="form-group">
                            <label for="password">Password Baru</label>
                            <input class="form-control" name="password" id="password" type="password">
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">Konfirmasi Password Baru</label>
                            <input class="form-control" name="password_confirmation" id="password_confirmation" type="password">
                        </div>
                    </div>
                </div>
            </div>

            <button class="float-right btn btn-primary" type="submit">Simpan</button>
    </form>
</x-card-table>
@endsection