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