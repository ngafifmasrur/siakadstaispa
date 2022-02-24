@extends('landing_page.layouts.app')
@section('title', $page->judul)

@section('content')

<!-- BLOG START -->
<section class="section bg-light mt-5 h-100" id="blog">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="title-heading mb-5">
                        <h3 class="text-dark mb-1 fw-semi-bold ">{{ $page->judul }}</h3>
                        <img src="{{ asset('landing_page/images/line.png') }}" alt="" width="120" class="  d-block">
                    </div>
                </div>
                <div class="col-lg-12"> 
                    {!! $page->content !!}
                </div>
                <!-- col end -->
            </div>
            <!-- row end -->
           
        </div>
        <!-- container end -->
    </section>
    <!-- BLOG END -->
@endsection