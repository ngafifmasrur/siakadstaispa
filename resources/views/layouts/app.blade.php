<!doctype html>
<html lang="en" dir="ltr">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta content="Sistem Akademik STAI Sunan Pandanaran" name="description">
		<meta content="STAI Sunan Pandanaran" name="author">
		<meta name="keywords" content="siakad, sistem akademik, staispa, STAI Sunan Pandanaran"/>
		<meta name="csrf-token" content="{{ csrf_token() }}">

		<!-- Favicon -->
		<link rel="icon" href="{{ asset('sparic/images/brand/favicon.ico') }}" type="image/x-icon"/>
		<link rel="shortcut icon" type="image/x-icon" href="{{ asset('sparic/images/brand/favicon.ico') }}" />

		<!-- Title -->
		<title>
            @yield('title')
            @if (trim($__env->yieldContent('title')))
                &mdash;
            @endif
            SIAKAD STAISPA
        </title>

		<!--Bootstrap.min css-->
		<link rel="stylesheet" href="{{ asset('sparic/plugins/bootstrap/css/bootstrap.min.css') }}">

		<!-- Dashboard css -->
		<link href="{{ asset('sparic/css/style.css') }}" rel="stylesheet" />
		<link href="{{ asset('sparic/css/skin-mode.css') }}" rel="stylesheet" />
		<link href="{{ asset('sparic/css/dark-style.css') }}" rel="stylesheet" />

		<!-- Perfect scroll bar css-->
		<link href="{{ asset('sparic/plugins/pscrollbar/perfect-scrollbar.css') }}" rel="stylesheet" />

		<!--Daterangepicker css-->
		<link href="{{ asset('sparic/plugins/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet" />

		<!-- Sidebar Accordions css -->
		<link href="{{ asset('sparic/css/easy-responsive-tabs.css') }}" rel="stylesheet">

		<!-- Rightsidebar css -->
		<link href="{{ asset('sparic/plugins/sidebar/sidebar.css') }}" rel="stylesheet">

		<!--News ticker css -->
		<link href="{{ asset('sparic/plugins/newsticker/breaking-news-ticker.css') }}" rel="stylesheet" />

		<!---Icons css-->
		<link href="{{ asset('sparic/css/icons.css') }}" rel="stylesheet" />

		<!--Fonts-->
		<link id="font" rel="stylesheet" type="text/css" media="all" href="{{ asset('sparic/colors/fonts/font1.css') }}"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/css/bootstrap-select.min.css" integrity="sha512-ARJR74swou2y0Q2V9k0GbzQ/5vJ2RBSoCWokg4zkfM29Fb3vZEQyv0iWBMW/yvKgyHSR/7D64pFMmU8nYmbRkg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

		<!-- Color-skins css -->
		<link id="theme" rel="stylesheet" type="text/css" media="all" href="{{ asset('sparic/colors/color-skins/color.css') }}" />
		<link rel="stylesheet" href="{{ asset('sparic/css/demo-styles.css') }}"/>
		
		<!-- Notifications  css -->
		<link href="{{ asset('sparic/plugins/notify-growl/css/jquery.growl.css')}}" rel="stylesheet" />
		<link href="{{ asset('sparic/plugins/notify-growl/css/notifIt.css')}}" rel="stylesheet" />

		<style>
			.dropdown-item.active, .dropdown-item:active {
				background-color: #007bff!important;
			}
			.cursor-pinter {
				cursor: pointer !important;
			}
			.bootstrap-select .dropdown-toggle:focus, .bootstrap-select>select.mobile-device:focus+.dropdown-toggle {
				outline: none !important;
			}
			.bootstrap-select.form-control {
				border: 1px solid rgba(107, 122, 144, 0.3);
			}
			.bootstrap-select>.dropdown-toggle {
				background: transparent;
			}
			.bootstrap-select>.dropdown-toggle:hover, 
			.bootstrap-select>.dropdown-toggle:active,
			.btn-light:not(:disabled):not(.disabled):active, 
			.btn-light:not(:disabled):not(.disabled).active {
				background: transparent;
				border: 1px solid transparent;
			}
		</style>
        @stack('css')
	</head>

	<body>

		<!--Global-Loader-->
		<div id="global-loader">
			<img src="{{ asset('sparic/images/brand/icon.png') }}" alt="loader">
		</div>

		<div class="page">
			<div class="page-main">
				<!--app-header-->
				<div class="app-header header d-flex">
					<div class="container">
						<div class="d-flex">
						    <a class="header-brand" href="{{ route('landing_page.index') }}">
								<img src="{{ asset('sparic/images/brand/logo.png') }}" class="header-brand-img main-logo" alt="Sparic logo">
								<img src="{{ asset('sparic/images/brand/icon.png') }}" class="header-brand-img icon-logo" alt="Sparic logo">
							</a><!-- logo-->
							<a id="horizontal-navtoggle" class="animated-arrow hor-toggle"><span></span></a>
							<a href="#" data-toggle="search" class="nav-link nav-link  navsearch"><i class="fa fa-search"></i></a><!-- search icon -->

                            <!--Top Navbar-->
                            @include('layouts.partials.top_navbar')
                            <!--END Top Navbar-->

							<div class="d-flex order-lg-2 ml-auto header-rightmenu">

								<div class="dropdown">
									<a  class="nav-link icon full-screen-link" id="fullscreen-button">
										<i class="fe fe-maximize-2"></i>
									</a>
								</div><!-- full-screen -->
								<div class="dropdown header-user">
									<a class="nav-link leading-none siderbar-link"  data-toggle="sidebar-right" data-target=".sidebar-right">
										<span class="mr-3 d-none d-lg-block ">
											<span class="text-gray-white"><span class="ml-2">{{ Auth::user()->name }}</span></span>
										</span>
										<span class="avatar avatar-md brround"><img src="{{ asset('sparic/images/users/avatars/19.png') }}" alt="Profile-img" class="avatar avatar-md brround"></span>
									</a>
									<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
										<div class="header-user text-center mt-4 pb-4">
											<span class="avatar avatar-xxl brround"><img src="{{ asset('sparic/images/users/avatars/19.png') }}" alt="Profile-img" class="avatar avatar-xxl brround"></span>
											<a href="#" class="dropdown-item text-center font-weight-semibold user h3 mb-0">Alison</a>
											<small>Web Designer</small>
										</div>
										<a class="dropdown-item" href="#">
											<i class="dropdown-icon mdi mdi-account-outline "></i> Spruko technologies
										</a>
										<a class="dropdown-item" href="#">
											<i class="dropdown-icon  mdi mdi-account-plus"></i> Add another Account
										</a>
										<div class="card-body border-top">
											<div class="row">
												<div class="col-6 text-center">
													<a class="" href=""><i class="dropdown-icon mdi  mdi-message-outline fs-30 m-0 leading-tight"></i></a>
													<div>Inbox</div>
												</div>
												<div class="col-6 text-center cursor-pointer">
													<a class="" href=""><i class="dropdown-icon mdi mdi-logout-variant fs-30 m-0 leading-tight"></i></a>
													<div>Sign out</div>
												</div>
											</div>
										</div>
									</div>
								</div><!-- profile -->
								<div class="header-form">
									<form class="form-inline">
										<div class="search-element mr-3">
											<input class="form-control" type="search" placeholder="Search" aria-label="Search">
											<span class="Search-icon"><i class="fa fa-search"></i></span>
										</div>
									</form><!-- search-bar -->
								</div>
								<div class="dropdown">
									<a  class="nav-link icon siderbar-link" data-toggle="sidebar-right" data-target=".sidebar-right">
										<i class="fe fe-more-horizontal"></i>
									</a>
								</div><!-- Right-siebar-->
							</div>
						</div>
					</div>
				</div>
                <!--/app-header-->
                
				<!--News Ticker-->
                @include('layouts.partials.news_ticker')
                <!--/News Ticker-->
                
				<!-- Horizontal-menu -->
				<div class="horizontal-main hor-menu clearfix">
					<div class="horizontal-mainwrapper container clearfix">
                        @include('layouts.partials.'.Auth::user()->role->name)
						<!--Nav end -->
					</div>
				</div>
				<!-- Horizontal-menu end -->

                <!-- app-content-->
				<div class="container content-area">
					<div class="side-app">

					    <!-- content -->
						
                        @yield('content')


					</div><!--End side app-->

                    <!-- Right-sidebar-->
                    @include('layouts.partials.sidebar_right')
					<!-- End Rightsidebar-->

				</div>
				<!-- End app-content-->
			</div>

			<!--footer-->
			<footer class="footer">
				<div class="container">
					<div class="row align-items-center flex-row-reverse">
						<div class="col-lg-12 col-sm-12   text-center">
							Copyright © 2022 <a href="#">Siakad Staispa</a> All rights reserved.
						</div>
					</div>
				</div>
			</footer>
			<!-- End Footer-->

		</div>
		<!-- End Page -->

		<!-- Back to top -->
		<a href="#top" id="back-to-top"><i class="fa fa-angle-up"></i></a>

		<!-- Jquery js-->
		<script src="{{ asset('sparic/js/vendors/jquery-3.2.1.min.js') }}" data-pagespeed-no-defer></script>

		<!--Bootstrap.min js-->
		<script src="{{ asset('sparic/plugins/bootstrap/popper.min.js') }}"></script>
		<script src="{{ asset('sparic/plugins/bootstrap/js/bootstrap.min.js') }}"></script>

		<!--Jquery Sparkline js-->
		<script src="{{ asset('sparic/js/vendors/jquery.sparkline.min.js') }}"></script>

		<!-- Chart Circle js-->
		<script src="{{ asset('sparic/js/vendors/circle-progress.min.js') }}"></script>

		<!--Moment js-->
		<script src="{{ asset('sparic/plugins/moment/moment.min.js') }}"></script>

		<!-- Daterangepicker js-->
		<script src="{{ asset('sparic/plugins/bootstrap-daterangepicker/daterangepicker.js') }}"></script>

		<!-- Horizontal-menu js -->
		<script src="{{ asset('sparic/plugins/horizontal-menu/horizontalmenu.js') }}"></script>

		<!--News Ticker js-->
		<script src="{{ asset('sparic/plugins/newsticker/breaking-news-ticker.min.js') }}"></script>
		<script src="{{ asset('sparic/plugins/newsticker/newsticker.js') }}"></script>

		<!-- Sidebar Accordions js -->
		<script src="{{ asset('sparic/plugins/sidemenu-responsive-tabs/js/easyResponsiveTabs.js') }}"></script>

		<!-- Perfect scroll bar js-->
		<script src="{{ asset('sparic/plugins/pscrollbar/perfect-scrollbar.js') }}"></script>

		<!-- Rightsidebar js -->
		<script src="{{ asset('sparic/plugins/sidebar/sidebar.js') }}"></script>

		<!--Time Counter js-->
		<script src="{{ asset('sparic/plugins/counters/jquery.missofis-countdown.js') }}"></script>
		<script src="{{ asset('sparic/plugins/counters/counter.js') }}"></script>

		<!-- ApexChart -->
		<script src="{{ asset('sparic/js/apexcharts.js') }}"></script>

		<!-- Charts js-->
		<script src="{{ asset('sparic/plugins/chart/chart.bundle.js') }}"></script>
		<script src="{{ asset('sparic/plugins/chart/utils.js') }}"></script>

		<!--Peitychart js-->
		<script src="{{ asset('sparic/plugins/peitychart/jquery.peity.min.js') }}"></script>
		<script src="{{ asset('sparic/plugins/peitychart/peitychart.init.js') }}"></script>

		<!-- Custom-charts js-->
		<script src="{{ asset('sparic/js/index1.js') }}"></script>

		<!-- Custom js-->
		<script src="{{ asset('sparic/js/custom.js') }}"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/js/bootstrap-select.min.js" integrity="sha512-yDlE7vpGDP7o2eftkCiPZ+yuUyEcaBwoJoIhdXv71KZWugFqEphIS3PU60lEkFaz8RxaVsMpSvQxMBaKVwA5xg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>        @stack('js')
		<script src="{{ asset('sparic/plugins/notify-growl/js/jquery.growl.js') }}" data-pagespeed-no-defer></script>
		<script src="{{ asset('sparic/plugins/notify-growl/js/notifIt.js') }}" data-pagespeed-no-defer></script>

		@if(Session::has('success_msg'))
			<script type="text/javascript">
				$.growl.notice({ duration: 3000, title: "Berhasil!",message: '{!! Session::get('success_msg') !!}' });
			</script>
		@endif

		@if(Session::has('error_msg'))
		<script type="text/javascript">
			$.growl.error({ duration: 3000, title: "Gagal!",message: '{!! Session::get('error_msg') !!}' });
		</script>
		@endif

        @stack('js')
	</body>
</html>