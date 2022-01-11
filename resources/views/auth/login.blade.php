<!doctype html>
<html lang="en" dir="ltr">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta content="Sistem Akademik STAI Sunan Pandanaran" name="description">
		<meta content="STAI Sunan Pandanaran" name="author">
		<meta name="keywords" content="siakad, sistem akademik, staispa, STAI Sunan Pandanaran"/>
		
		<!-- Favicon -->
		<link rel="icon" href="{{ asset('sparic/images/brand/favicon.ico') }}" type="image/x-icon"/>
		<link rel="shortcut icon" type="image/x-icon" href="{{ asset('sparic/images/brand/favicon.ico') }}" />

		<!-- Title -->
        <title>Login - SIAKAD STAISPA</title>

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

		<!---Icons css-->
		<link href="{{ asset('sparic/css/icons.css') }}" rel="stylesheet" />

		<!--Fonts-->
		<link id="font" rel="stylesheet" type="text/css" media="all" href="{{ asset('sparic/colors/fonts/font1.css') }}"/>

		<!-- Color-skins css -->
		<link id="theme" rel="stylesheet" type="text/css" media="all" href="{{ asset('sparic/colors/color-skins/color.css') }}" />
		<link rel="stylesheet" href="{{ asset('sparic/css/demo-styles.css') }}"/>

	</head>
	<body class="bg-account">
	    <!-- page -->
		<div class="page h-100">

			<!-- page-content -->
			<div class="page-content">
				<div class="container text-center text-dark">
					<div class="row">
						<div class="col-lg-4 d-block mx-auto">
							<div class="row">
								<div class="col-xl-12 col-md-12 col-md-12">
									<div class="card">
										<div class="card-body">
											<x-auth-session-status class="mb-4" :status="session('status')" />

											<!-- Validation Errors -->
											<x-auth-validation-errors class="mb-4" :errors="$errors" />

											<div class="text-center mb-6">
												<img src="{{ asset('sparic/images/brand/logo.png') }}" class="" alt="">
											</div>
											<h3>Login</h3>
											<p class="text-muted">Sign In to your account</p>
											<form method="POST" action="{{ route('login') }}">
												@csrf
												<div class="input-group mb-3">
													<span class="input-group-addon bg-white"><i class="fa fa-user"></i></span>
													<input type="text" class="form-control" placeholder="Email / NIM / NIDN" name="email">
												</div>
												<div class="input-group mb-4">
													<span class="input-group-addon bg-white"><i class="fa fa-unlock-alt"></i></span>
													<input type="password" class="form-control" placeholder="Password" name="password">
												</div>
												<div class="row">
													<div class="col-12">
														<button type="submit" class="btn btn-primary btn-block">Login</button>
													</div>
													<!-- <div class="col-12">
														<a href="forgot-password.html" class="btn btn-link box-shadow-0 px-0">Forgot password?</a>
													</div> -->
												</div>
											</form>
											<!-- <div class="mt-6 btn-list">
												<button type="button" class="btn btn-icon btn-facebook"><i class="fa fa-facebook"></i></button>
												<button type="button" class="btn btn-icon btn-google"><i class="fa fa-google"></i></button>
												<button type="button" class="btn btn-icon btn-twitter"><i class="fa fa-twitter"></i></button>
												<button type="button" class="btn btn-icon btn-dribbble"><i class="fa fa-dribbble"></i></button>
											</div> -->
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

			</div>
			<!-- page-content end -->
		</div>
		<!-- page End-->

		<!-- Jquery js-->
		<script src="{{ asset('sparic/js/vendors/jquery-3.2.1.min.js') }}"></script>

		<!--Bootstrap.min js-->
		<script src="{{ asset('sparic/plugins/bootstrap/popper.min.js') }}"></script>
		<script src="{{ asset('sparic/plugins/bootstrap/js/bootstrap.min.js') }}"></script>

		<!--Jquery Sparkline js-->
		<script src="{{ asset('sparic/js/vendors/jquery.sparkline.min.js') }}"></script>

		<!-- Chart Circle js-->
		<script src="{{ asset('sparic/js/vendors/circle-progress.min.js') }}"></script>

		<!-- Sidebar Accordions js -->
		<script src="{{ asset('sparic/plugins/sidemenu-responsive-tabs/js/easyResponsiveTabs.js') }}"></script>

		<!--Moment js-->
		<script src="{{ asset('sparic/plugins/moment/moment.min.js') }}"></script>

		<!-- Daterangepicker js-->
		<script src="{{ asset('sparic/plugins/bootstrap-daterangepicker/daterangepicker.js') }}"></script>

		<!-- Perfect scroll bar js-->
		<script src="{{ asset('sparic/plugins/pscrollbar/perfect-scrollbar.js') }}"></script>

		<!-- Custom js-->
		<script src="{{ asset('sparic/js/custom.js') }}"></script>

	</body>
</html>