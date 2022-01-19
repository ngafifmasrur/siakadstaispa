<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Siakad STAISPA</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Siakad Staispa" />
    <meta name="keywords" content="Siakad Staispa" />
    <meta content="Themesbrand" name="author" />
    <!-- favicon -->
    <link rel="shortcut icon" href="{{ asset('landing_page/images/logo.png') }}">

    <!--Material Icon -->
    <link rel="stylesheet" type="text/css" href="{{ asset('landing_page/css/materialdesignicons.min.css') }}" />

    <!-- Pixeden Icon -->
    <link rel="stylesheet" type="text/css" href="{{ asset('landing_page/css/pe-icon-7.css') }}" />

    <!-- tinyslider -->
    <link rel="stylesheet" href="{{ asset('landing_page/css/tiny-slider.css') }}">

    <!-- css -->
    <link href="{{ asset('landing_page/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('landing_page/css/materialdesignicons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('landing_page/css/style.css') }}" rel="stylesheet" type="text/css" />

</head>

<body onload="return preloader();">

    <!-- Loader -->
    <div id="preloader">
        <div id="status">
            <div class="sk-cube-grid">
                <div class="sk-cube sk-cube1"></div>
                <div class="sk-cube sk-cube2"></div>
                <div class="sk-cube sk-cube3"></div>
                <div class="sk-cube sk-cube4"></div>
                <div class="sk-cube sk-cube5"></div>
                <div class="sk-cube sk-cube6"></div>
                <div class="sk-cube sk-cube7"></div>
                <div class="sk-cube sk-cube8"></div>
                <div class="sk-cube sk-cube9"></div>
            </div>
        </div>
    </div>

    <!--Navbar Start-->
	<nav class="navbar navbar-expand-lg fixed-top navbar-custom sticky sticky-dark" id="navbar">
        <div class="container">
            <!-- LOGO -->
            <a class="navbar-brand logo" href="{{ url('/home') }}">
                <img src="{{ asset('landing_page/images/logo_text.png') }}" alt="" height="30">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse"
                aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <i class="mdi mdi-menu"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav ms-auto navbar-center" id="navbar-navlist">
                    <li class="nav-item">
                        <a href="{{ route('landing_page.index') }}" class="nav-link">Home</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('landing_page.berita') }}" class="nav-link">Berita</a>
                    </li>
                    <!-- <li class="nav-item">
                        <a href="#services" class="nav-link">Aktivasi</a>
                    </li> -->
                    <li class="nav-item active">
                        @auth
                            <a href="{{ route(Auth::user()->role->name.'.dashboard') }}"" class="nav-link">Login</a>
                        @else
                            <a href="{{ url('/login') }}"" class="nav-link">Login</a>
                        @endauth
                    </li>
                    <li class="nav-item">
                        <a href="#features" class="nav-link">Kontak</a>
                    </li>
                </ul>

            </div>
        </div>
    </nav>
    <!-- Navbar End -->

	<section class="section login-bg">
		<div class="container" style="padding-top:50px;">
			<div class="title-heading mb-5">
                        <h3 class="text-white mb-1 fw-semi-bold ">LOGIN</h3>
                        <img src="{{ asset('landing_page/images/line.png') }}" alt="" width="120" class="  d-block">
             </div>
		</div>
		<div align="center">
			<div class="col-lg-6" style="padding-top:100px;">
				<div class="card" >
					<div class="card-body p-5">
					<x-auth-session-status class="mb-4" :status="session('status')" />
					<!-- Validation Errors -->
					<x-auth-validation-errors class="mb-4" :errors="$errors" />
					<form method="POST" action="{{ route('login') }}">
						@csrf
						<h5 class="mb-2 fw-semi-bold" align="left">Username :</h5>
						<div class="form-group mb-3">
							<span class="input-group-addon bg-white"><i class="fa fa-user"></i></span>
							<input type="text" class="form-control" placeholder="Masukan username yang di kehendaki, contoh: Andrian" name="email">
						</div>
						<h5 class="mb-2 fw-semi-bold" align="left">Password :</h5>
						<div class="form-group mb-4">
							<span class="input-group-addon bg-white"><i class="fa fa-unlock-alt"></i></span>
							<input type="password" class="form-control" placeholder="Password" name="password">
						</div>
						<div class="col-lg-12">	
							<button type="submit" style="color:white; border-radius: 10px;display: block;width: 100%;border: none;background-color: #D75746;padding: 14px 28px;font-size: 16px;cursor: pointer;text-align: center;">Masuk</button>
						</div>
					</form>
					</div>
				</div>
			<div>
			<p class="text-muted mb-3 f-14 pt-5">Silahkan login pada form yang telah disediakan pada form di atas.</p>
		</div>
    </section>

    <!-- FOOTER START -->
	<section class="footer-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="mb-5">
                        <img src="{{ asset('landing_page/images/logo_text.png') }}" alt="" height="40">
                        <p class="text-white mt-1 f-14">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                    </div>
                </div>
                <!-- col end -->
                <div class="col-lg-9">
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="mb-5">
                                <p class="text-uppercase text-white footer-title mb-4">SERVICE</p>
                                <ul class="list-unstyled footer-sub-menu">
                                    <li class="f-14"><a href="" class="text-white">Virtual Class</a></li>
                                    <li class="f-14"><a href="" class="text-white">E-learning</a></li>
                                    <li class="f-14"><a href="" class="text-white">Portofolio</a></li>
                                    <li class="f-14"><a href="" class="text-white">Helpdesk</a></li>
                                </ul>
                            </div>
                        </div>
                        <!-- col end -->

                        <div class="col-lg-3">
                            <div class="mb-5">
                                <p class="text-uppercase text-white footer-title mb-4">BLOG</p>
                                <ul class="list-unstyled footer-sub-menu">
                                    <li class="f-14"><a href="" class="text-white">Lorem Ipsum</a></li>
                                    <li class="f-14"><a href="" class="text-white">Lorem Ipsum</a></li>
                                    <li class="f-14"><a href="" class="text-white">Lorem Ipsum</a></li>
                                    <li class="f-14"><a href="" class="text-white">Lorem Ipsum</a></li>
                                </ul>
                            </div>
                        </div>
                        <!-- col end -->

                        <div class="col-lg-3">
                            <div class="mb-5">
                                <p class="text-uppercase text-white footer-title mb-4">BLOG</p>
                                <ul class="list-unstyled footer-sub-menu">
                                    <li class="f-14"><a href="" class="text-white">Lorem Ipsum</a></li>
                                    <li class="f-14"><a href="" class="text-white">Lorem Ipsum</a></li>
                                    <li class="f-14"><a href="" class="text-white">Lorem Ipsum</a></li>
                                    <li class="f-14"><a href="" class="text-white">Lorem Ipsum</a></li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="mb-5">
                                <p class="text-uppercase text-white footer-title mb-4">Ikuti Kami di</p>
                                <div class="row">
                                    <div class="col-lg-2 col-md-4 col-sm-4 mb-2">
                                        <a href="#">    
                                        <img src="{{ asset('landing_page/images/ic_fb.png') }}" alt="" height="30"> 
                                        </a>
                                    </div>
                                    <div class="col-lg-2 col-md-4 col-sm-4 mb-2">
                                        <a href="#">    
                                        <img src="{{ asset('landing_page/images/ic_ig.png') }}" alt="" height="30"> 
                                        </a>
                                    </div>
                                    <div class="col-lg-2 col-md-4 col-sm-4 mb-2">
                                        <a href="#">    
                                        <img src="{{ asset('landing_page/images/ic_yt.png') }}" alt="" height="30"> 
                                        </a>
                                    </div>
                                    <div class="col-lg-2 col-md-4 col-sm-4 mb-2">
                                        <a href="#">    
                                        <img src="{{ asset('landing_page/images/ic_in.png') }}" alt="" height="30"> 
                                        </a>
                                    </div>
                                    <div class="col-lg-2 col-md-4 col-sm-4 mb-2">
                                        <a href="#">    
                                        <img src="{{ asset('landing_page/images/ic_wa.png') }}" alt="" height="30"> 
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- col end -->
                    </div>
                    <!-- row end -->
                </div>
                <!-- col end -->
            </div>
            <!-- row end -->
        </div>
        <!-- container end -->
    </section>
    <!-- FOOTER END -->

    <!-- FOOTER ALT START -->
    <section class="footer-alt bg-dark pt-3 pb-3">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <p class="copyright text-white f-14 fw-light mb-0">
                        <script>document.write(new Date().getFullYear())</script> Copyright 2021 © All rights reserved.
                    </p>
                </div>
                <!-- col end -->
            </div>
            <!-- row end -->
        </div>
        <!-- container end -->
    </section>
    <!-- FOOTER ALT END -->

    <script src="{{ asset('landing_page/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('landing_page/js/smooth-scroll.polyfills.min.js') }}"></script>
    <script src="{{ asset('landing_page/js/gumshoe.polyfills.min.js') }}"></script>
    <script src="{{ asset('landing_page/js/tiny-slider.js') }}"></script>
    <!-- Main Js -->
    <script src="{{ asset('landing_page/js/app.js') }}"></script>
</body>

</html>