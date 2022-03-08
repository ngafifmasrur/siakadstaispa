<header class="app-header navbar border-light">
	<button class="navbar-toggler sidebar-toggler d-lg-none mr-auto" type="button" data-toggle="sidebar-show">
		<span class="navbar-toggler-icon"></span>
	</button> 
	<a class="navbar-brand" href="{{ route('admission.admin.dashboard') }}">
		<small class="navbar-brand-full text-dark"><strong><span class="text-success">{{ strtoupper(config('admission.admin.navbar.brand')) }}</span> {{ config('admission.admin.navbar.brand_ext') }}</strong></small>
		<img class="navbar-brand-minimized" src="{{ asset('assets/img/logo/icon-rn32.png') }}" width="32">
	</a> 
	<button class="navbar-toggler sidebar-toggler d-md-down-none" type="button" data-toggle="sidebar-lg-show"> 
		<span class="navbar-toggler-icon"></span> 
	</button>
	<ul class="nav navbar-nav mr-auto d-none d-lg-flex">
		<li class="nav-item px-3"> <a class="nav-link" href="{{ route('admission.index') }}"> Utama </a> </li>
		<li class="nav-item px-3"> <a class="nav-link" href="{{ route('admission.admin.dashboard') }}"> Dasbor </a> </li>
	</ul>
	<ul class="nav navbar-nav ml-auto mr-2">
		<li class="nav-item dropdown">
			<a class="nav-link" data-toggle="dropdown" href="javascript:;" role="button" aria-haspopup="true" aria-expanded="false"> <img class="img-avatar" src="{{ asset('assets/img/avatar.svg') }}" style="height:32px;"> <span class="d-md-down-none pr-3">{{ auth()->user()->username }}</span> </a> 
			<div class="dropdown-menu dropdown-menu-right">
				<div class="dropdown-header text-center"> <strong>Akun</strong> </div>
				<a class="dropdown-item" href="{{ route('account.user.password', ['next' => url()->current()]) }}"> <i class="mdi mdi-lock"></i> Ubah sandi </a>
				<a class="dropdown-item" href="javascript:;" onclick="if (confirm('Apakah Anda yakin?')) document.getElementById('logout-form').submit()"> <i class="mdi mdi-logout"></i> Logout</a> 
			</div>
		</li>
	</ul>
</header>