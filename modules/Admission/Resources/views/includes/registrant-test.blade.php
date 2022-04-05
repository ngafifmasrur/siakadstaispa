{{-- @php
	$lists = [
		'Tanggal tes'			=> $registrant->test_at ? $registrant->test_at->formatLocalized('%A, %d %B %Y') : '-',
		'Sesi tes'				=> $registrant->test_at ? ($registrant->session->name.' ('.substr($registrant->session->start_time, 0, 5).'-'.substr($registrant->session->end_time, 0, 5).')') : '-',
	];
@endphp

<div class="card">
	<div class="card-body">
		<h5 class="mb-4">Tanggal dan sesi tes</h5>
		<ul class="list-unstyled mb-0">
			@foreach($lists as $key => $list)
				<li @if(!$loop->last) class="mb-2" @endif>
					<span class="font-weight-bold">{{ $key }}</span> <br>
					{{ $list }}
				</li>
			@endforeach
		</ul>
	</div>
</div> --}}