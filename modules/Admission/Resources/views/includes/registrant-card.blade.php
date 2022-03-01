<div class="card card-body bg-dark">
	<div class="row">
		<div class="col-sm-3 text-center">
			<img src="{{ $registrant->avatar ? Storage::url($registrant->avatar) : asset('assets/img/avatar.svg') }}" class="rounded-circle mb-4 mb-sm-0" style="width: 100px; height: 100px; object-fit:cover;">
		</div>
		<div class="col-sm-9 align-self-center text-center text-sm-left">
			<h2 class="mb-0">{{ $registrant->user->profile->full_name }}</h2>
			<h5 class="text-muted font-weight-normal">{{ $registrant->admission->name }} / {{ $registrant->kd }}</h5>
			<h5>@include('admission::includes.registrant-progress-badge', compact('registrant'))</h5>
		</div>
	</div>
</div>