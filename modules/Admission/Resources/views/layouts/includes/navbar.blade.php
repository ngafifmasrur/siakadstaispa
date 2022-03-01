<nav class="navbar navbar-expand-md @isset($primary) navbar-light bg-transparent fixed-top @else navbar-dark bg-success mb-4 @endif">
	<div class="container">
		<a class="navbar-brand h5 mb-0 @isset($primary) py-4 @endif" href="/">
			<img src="{{ asset('assets/img/logo/icon-rn32.png') }}" class="mr-2">
			{{ config('admission.navbar.brand_long') }}
		</a>
		@if(\Modules\Admission\Models\Admission::opened()->count())
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navcollapse" aria-controls="navcollapse" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navcollapse">
				<ul class="navbar-nav ml-auto">
					@auth
					@can('registration', Admission::class)
						<li class="nav-item pr-3"><a class="nav-link" href="{{ route('admission.home') }}">DATA PENDAFTARAN</a></li>
					@else
						<li class="nav-item pr-3"><a class="nav-link" href="{{ route('admission.register') }}">DAFTAR</a></li>
					@endcan
					@if(auth()->user()->admissionCommittees()->exists())
						<li class="nav-item pr-3"><a class="nav-link" href="{{ route('admission.admin.dashboard') }}">ADMINSITRASI</a></li>
					@endif
						<li class="nav-item"><a class="nav-link" href="javascript:;" onclick="if (confirm('Apakah Anda yakin?')) document.getElementById('logout-form').submit()">LOGOUT</a></li>
					@else
						<li class="nav-item pr-3"> <a class="nav-link" href="{{ route('account.login', ['next' => url()->current()]) }}">MASUK</a> </li>
						@if(count(config('admission.closed')) != 2)
						    <li class="nav-item"> <a class="nav-link btn btn-sm btn-success btn-pill px-4" href="{{ auth()->check() ? route('admission.register') : route('account.register', ['next' => route('admission.register')]) }}" tabindex="-1">DAFTAR</a> </li>    
					    @endif
					@endauth
				</ul>
			</div>
		@endif
	</div>
</nav>