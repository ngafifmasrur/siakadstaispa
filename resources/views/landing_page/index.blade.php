@extends('landing_page.layouts.app')
@section('title', 'Landing Page - Home')

@section('content')
<!-- HOME START -->
<section class="section home-2-bg" id="home">
        <div class="home-center">
            <div class="home-desc-center">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-5">
                            <div class="mt-5 home-2-content">
                                <h1 class="text-white fw-normal home-2-title  mb-0">Sistem Informasi Akademik STAISPA</h1>
                                <p class="text-white-70 mt-4 f-15 mb-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sit nibh non ultrices placerat sit felis turpis elit. Mollis ut sed nunc suspendisse.</p>
                            </div>
                        </div>
                        <!-- col end -->

                        
                        <!-- col end -->
                    </div>
                    <!-- row end -->
                </div>
                <!-- container end -->
            </div>
        </div>
    </section>
    <!-- HOME END -->

    <!-- ABOUT START -->
    <section class="section bg-about bg-light-about " id="about">
        <div class="container">

            <div class="row">
                <div class="col-lg-4">
                    <div class="about-box about-light text-center p-3">
                        <div class="about-icon mb-4">
                            <img src="{{ asset('landing_page/images/ic_desc_1.png') }}" alt="" class="img-fluid mx-auto d-block">
                        </div>
                        <h4 class="fw-normal"><a href="#" class="text-dark">Satu Akun Untuk Semua</a></h4>
                        <img src="{{ asset('landing_page/images/line.png') }}" alt="" width="120" class=" mx-auto d-block">
                        <p class="text-muted f-14 mt-2">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mattis amet elementum vitae.</p>
                    </div>
                </div>
                <!-- col end -->

                <div class="col-lg-4">
                    <div class="about-box about-light text-center p-3">
                        <div class="about-icon mb-4">
                            <img src="{{ asset('landing_page/images/ic_desc_2.png') }}" alt="" class="img-fluid mx-auto d-block">
                        </div>
                        <h4 class="fw-normal"><a href="#" class="text-dark">Akses dari mana saja</a></h4>
                        <img src="{{ asset('landing_page/images/line.png') }}" alt="" width="120" class=" mx-auto d-block">
                        <p class="text-muted f-14 mt-2">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mattis amet elementum vitae.</p>
                    </div>
                </div>
                <!-- col end -->

                <div class="col-lg-4">
                    <div class="about-box about-light text-center p-3">
                        <div class="about-icon mb-4">
                            <img src="{{ asset('landing_page/images/ic_desc_3.png') }}" alt="" class="img-fluid mx-auto d-block">
                        </div>
                        <h4 class="fw-normal"><a href="#" class="text-dark">Kemudahan</a></h4>
                        <img src="{{ asset('landing_page/images/line.png') }}" alt="" width="120" class=" mx-auto d-block">
                        <p class="text-muted f-14 mt-2">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mattis amet elementum vitae.</p>
                    </div>
                </div>
                <!-- col end -->
            </div>
            <!-- row end -->
        </div>
        <!-- container end -->
    </section>
    <!-- ABOUT END -->

    <div class="container">
        <hr>
    </div>

    <!-- SERVICE START -->
    <section class="section" id="services">
        <div class="container">

            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="service-box mt-4 p-4" style="background-color:#4EA390;">
                        <div class="row">
                            <div class="col-lg-3 service-icon mb-3" style="background-image: url('{{ asset('landing_page/images/ic_akademik.png') }}');background-size: cover;"></div>
                            <div class="col-lg-9 service-title">
                                <h5 class="fw-normal mb-2 mt-3"><a href="#" class="text-white">Akademik</a></h5>
                                <img src="{{ asset('landing_page/images/line2.png') }}" alt="" width="120" class="d-block">
                            </div>
                        </div>
                        <div class="services-desc">
                            <p class="text-white mb-3 f-14">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mattis amet elementum vitae.</p>
                        </div>
                    </div>
                </div>
                <!-- col end -->

                <div class="col-lg-4 col-md-6">
                    <div class="service-box mt-4 p-4" style="background-color:#C2C851;">
                        <div class="row">
                            <div class="col-lg-3 service-icon mb-3" style="background-image: url('{{ asset('landing_page/images/ic_perpustakaan.png') }}');background-size: cover;"></div>
                            <div class="col-lg-9 service-title">
                                <h5 class="fw-normal mb-2 mt-3"><a href="#" class="text-white">Perpustakaan</a></h5>
                                <img src="{{ asset('landing_page/images/line2.png') }}" alt="" width="120" class="d-block">
                            </div>
                        </div>
                        <div class="services-desc">
                            <p class="text-white mb-3 f-14">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mattis amet elementum vitae.</p>
                        </div>
                    </div>
                </div>
                <!-- col end -->

                <div class="col-lg-4 col-md-6">
                    <div class="service-box mt-4 p-4" style="background-color:#4EA390;">
                        <div class="row">
                            <div class="col-lg-3 service-icon mb-3" style="background-image: url('{{ asset('landing_page/images/ic_surat_keterangan.png') }}');background-size: cover;"></div>
                            <div class="col-lg-9 service-title">
                                <h5 class="fw-normal mb-2 mt-3"><a href="#" class="text-white">Surat Keterangan</a></h5>
                                <img src="{{ asset('landing_page/images/line2.png') }}" alt="" width="120" class="d-block">
                            </div>
                        </div>
                        <div class="services-desc">
                            <p class="text-white mb-3 f-14">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mattis amet elementum vitae.</p>
                        </div>
                    </div>
                </div>
                <!-- col end -->

                <div class="col-lg-4 col-md-6">
                    <div class="service-box mt-4 p-4" style="background-color:#C2C851;">
                        <div class="row">
                            <div class="col-lg-3 service-icon mb-3" style="background-image: url('{{ asset('landing_page/images/ic_baak.png') }}');background-size: cover;"></div>
                            <div class="col-lg-9 service-title">
                                <h5 class="fw-normal mb-2 mt-3"><a href="#" class="text-white">BAAK</a></h5>
                                <img src="{{ asset('landing_page/images/line2.png') }}" alt="" width="120" class="d-block">
                            </div>
                        </div>
                        <div class="services-desc">
                            <p class="text-white mb-3 f-14">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mattis amet elementum vitae.</p>
                        </div>
                    </div>
                </div>
                <!-- col end -->

                <div class="col-lg-4 col-md-6">
                    <div class="service-box mt-4 p-4" style="background-color:#4EA390;">
                        <div class="row">
                            <div class="col-lg-3 service-icon mb-3" style="background-image: url('{{ asset('landing_page/images/ic_portofolio_mahasiswa.png') }}');background-size: cover;"></div>
                            <div class="col-lg-9 service-title">
                                <h5 class="fw-normal mb-2 mt-3"><a href="#" class="text-white">Portofolio Mahasiswa</a></h5>
                                <img src="{{ asset('landing_page/images/line2.png') }}" alt="" width="120" class="d-block">
                            </div>
                        </div>
                        <div class="services-desc">
                            <p class="text-white mb-3 f-14">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mattis amet elementum vitae.</p>
                        </div>
                    </div>
                </div>
                <!-- col end -->

                <div class="col-lg-4 col-md-6">
                    <div class="service-box mt-4 p-4" style="background-color:#C2C851;">
                        <div class="row">
                            <div class="col-lg-3 service-icon mb-3" style="background-image: url('{{ asset('landing_page/images/ic_blog.png') }}');background-size: cover;"></div>
                            <div class="col-lg-9 service-title">
                                <h5 class="fw-normal mb-2 mt-3"><a href="#" class="text-white">Blog</a></h5>
                                <img src="{{ asset('landing_page/images/line2.png') }}" alt="" width="120" class="d-block">
                            </div>
                        </div>
                        <div class="services-desc">
                            <p class="text-white mb-3 f-14">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mattis amet elementum vitae.</p>
                        </div>
                    </div>
                </div>
                <!-- col end -->

                
            </div>
            <!-- row end -->
        </div>
        <!-- container end -->
    </section>
    <!-- SERVICE END -->

    <!-- BLOG START -->
    <section class="section bg-light" id="blog">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="title-heading mb-5">
                        <h3 class="text-dark mb-1 fw-normal ">Blog Terbaru</h3>
                        <img src="{{ asset('landing_page/images/line.png') }}" alt="" width="150" class="  d-block">
                    </div>
                </div>
                <!-- col end -->
            </div>
            <!-- row end -->

            <div class="row">
                <div class="col-lg-12 mb-4">
                    <div class="blog">
                        <div class="blog-content bg-white p-4">
                                <div class="row">
                                    <div class="col-lg-1">
                                        <img src="{{ asset('landing_page/images/imp_logo.png') }}" alt="" width="80" class="  d-block">
                                    </div>
                                    <div class="col-lg-9 ml-2">
                                        <h4 class="fw-normal"><a href="#" class="text-dark">Lorem isum dolor sit amet</a></h4>
                                        <p class="f-13 mb-2 text-muted"> September 1, 2020&emsp;|&emsp;Posted by: Admin</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-9">
                                        <p class="text-muted f-14">
                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sit nibh non ultrices placerat sit felis turpis elit. Mollis ut sed nunc suspendisse faucibus adipiscing sed ac amet. Blandit morbi posuere elit mi fermentum dignissim porta. Volutpat est id et ut nunc mattis pretium sit donec.......................
                                        </p>
                                    </div>
                                    <div class="col-lg-3">
                                        <a href="#" class="btn btn-custom me-4">Read More</a>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
                <!-- col end -->

                <div class="col-lg-12 mb-4">
                    <div class="blog">
                        <div class="blog-content bg-white p-4">
                                <div class="row">
                                    <div class="col-lg-1">
                                        <img src="{{ asset('landing_page/images/imp_logo.png') }}" alt="" width="80" class="  d-block">
                                    </div>
                                    <div class="col-lg-9 ml-2">
                                        <h4 class="fw-normal"><a href="#" class="text-dark">Lorem isum dolor sit amet</a></h4>
                                        <p class="f-13 mb-2 text-muted"> September 1, 2020&emsp;|&emsp;Posted by: Admin</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-9">
                                        <p class="text-muted f-14">
                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sit nibh non ultrices placerat sit felis turpis elit. Mollis ut sed nunc suspendisse faucibus adipiscing sed ac amet. Blandit morbi posuere elit mi fermentum dignissim porta. Volutpat est id et ut nunc mattis pretium sit donec.......................
                                        </p>
                                    </div>
                                    <div class="col-lg-3">
                                        <a href="#" class="btn btn-custom me-4">Read More</a>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
                <!-- col end -->

                <div class="col-lg-12 mb-4">
                    <div class="blog">
                        <div class="blog-content bg-white p-4">
                                <div class="row">
                                    <div class="col-lg-1">
                                        <img src="{{ asset('landing_page/images/imp_logo.png') }}" alt="" width="80" class="  d-block">
                                    </div>
                                    <div class="col-lg-9 ml-2">
                                        <h4 class="fw-normal"><a href="#" class="text-dark">Lorem isum dolor sit amet</a></h4>
                                        <p class="f-13 mb-2 text-muted"> September 1, 2020&emsp;|&emsp;Posted by: Admin</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-9">
                                        <p class="text-muted f-14">
                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sit nibh non ultrices placerat sit felis turpis elit. Mollis ut sed nunc suspendisse faucibus adipiscing sed ac amet. Blandit morbi posuere elit mi fermentum dignissim porta. Volutpat est id et ut nunc mattis pretium sit donec.......................
                                        </p>
                                    </div>
                                    <div class="col-lg-3">
                                        <a href="#" class="btn btn-custom me-4">Read More</a>
                                    </div>
                                </div>
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