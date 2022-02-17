@extends('landing_page.layouts.app')
@section('title', 'Landing Page - Berita')

@section('content')

<!-- BLOG START -->
<section class="section bg-light mt-5" id="blog">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="title-heading mb-5">
                        <h3 class="text-dark mb-1 fw-semi-bold ">Berita</h3>
                        <img src="{{ asset('landing_page/images/line.png') }}" alt="" width="120" class="  d-block">
                        <form method="GET">
                        <input type="text" class="form-control mt-4" name="search" placeholder="Search">
                        <form>
                    </div>
                </div>
                <!-- col end -->
            </div>
            <!-- row end -->
            <div class="row">
            @foreach($berita as $key)
            <div class="col-lg-12 mb-4">
                <div class="blog">
                    <div class="blog-content bg-white p-4">
                        <div class="row">
                            <div class="col-lg-1">
                                <img src="{{ url('upload/berita_img/'.$key->gambar) }}"  style="object-fit: cover;width: 100%;" height="60">
                            </div>
                            <div class="col-lg-9 ml-2">
                                <h1 class="fw-normal" style="font-size: 1.5rem"><a href="#" class="text-dark">{{ $key->judul }}</a></h1>
                                <p class="f-13 mb-2 text-muted"> {{ date_format($key->created_at,'d M Y - h:i a') }}&emsp;|&emsp;Posted by: Admin</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-9">
                                <p class="text-muted f-14">
                                  <?= substr($key->isi,0,200); ?>...
                                </p>
                            </div>
                            <div class="col-lg-3">
                                <a href="{{ url('berita/'.$key->id) }}" class="btn btn-custom me-4">Read More</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            </div>
            <!-- row end -->
            {{ $berita->render("pagination::bootstrap-4") }}
        </div>
        <!-- container end -->
    </section>
    <!-- BLOG END -->
@endsection