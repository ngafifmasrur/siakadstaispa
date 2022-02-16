@extends('landing_page.layouts.app')
@section('title', 'Landing Page - Berita')

@section('content')

<!-- BLOG START -->
<section class="section bg-light mt-5" id="blog">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="title-heading mb-5">
                        <h3 class="text-dark mb-1 fw-semi-bold ">{{ $berita->judul }}</h3>
                        <img src="{{ asset('landing_page/images/line.png') }}" alt="" width="120" class="  d-block">
                    </div>
                </div>
                <div class="col-lg-12"> 
                    <div class="card">
                    <div class="card-body">
                        <img src="{{ url('upload/berita_img/'.$berita->gambar)}}" style="object-fit: cover;width: 100%;" height="400" width="500">
                        <p class="f-13 mb-2 text-muted"> {{ date_format($berita->created_at,'d M Y - h:i a') }}&emsp;|&emsp;dilihat : {{$berita->hits}} kali&emsp;|&emsp;Posted by: Admin</p>
                        <h4 class="card-title mt-2">{{ $berita->judul }}</h4>
                        <?= $berita->isi; ?>
                    </div>
                    </div>
                </div>
                <!-- col end -->
            </div>
            <!-- row end -->
           
        </div>
        <!-- container end -->
    </section>
    <!-- BLOG END -->
@endsection