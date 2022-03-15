@php
$forms = $registrant->admission->forms;

$required = $forms->filter(function ($v){
    return $v->required == true;
});

$count = count($required->filter(function ($v) use ($registrant){
	return $v->getStatus($registrant);
}));

$precentage = ($count) ? number_format(($count / count($required) ?: 0.05) * 100, 2) : 5;

if ($precentage <= 60) {
	$color = 'bg-danger';
} elseif ($precentage <= 99) {
	$color = 'bg-warning';
} else {
	$color = 'bg-success';
}

$name = $registrant->user_id == auth()->id() ? 'Anda' : $registrant->user->profile->name;
@endphp


@if ($registrant->is_saman == 1)
	@php
	$statusses = [
		['step' => 'Terdaftar', 'status' => $precentage == 100 ? true : false],
		['step' => 'Tes CBT', 'status' => $status_cbt],
		['step' => 'Pilih Tanggal kedatangan', 'status' => $registrant->tanggal_kedatangan ? true : false],
		['step' => 'Wawancara', 'status' => $registrant->status_wawancara == 1 ? true : false],
		['step' => 'Unduh Surat Keterangan Diterima', 'status' => $precentage == 100 ? true : false],
	];
	@endphp
@else
@php
	$statusses = [
		['step' => 'Terdaftar', 'status' => $precentage == 100 ? true : false],
		['step' => 'Tes CBT', 'status' => $status_cbt],
		['step' => 'Pilih Tanggal kedatangan', 'status' => $registrant->tanggal_kedatangan ? true : false],
		['step' => 'Pembayaran', 'status' => $registrant->paid_off_at ? true : false],
		['step' => 'Unduh Surat Keterangan Diterima', 'status' => $precentage == 100 ? true : false],
	];
	@endphp
@endif

<div class="card">

	<div class="card-body">
		<h5 class="mb-0">Status tahap pendaftaran
		</h5>
		<p class="mb-0"><small class="text-muted">Saat ini status Anda adalah <strong>{{ $registrant->step_status }}</strong></small></p>
	</div>
	<div class="table-responsive">
		<table class="table table-striped border-bottom mb-0">
			<thead>
				<tr class="bg-dark text-white">
					<th width="1">No.</th>
					<th>Tahap pendaftaran</th>
					<th>Status</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($statusses as $status)
				<tr>
					<td class="text-center">{{ $loop->iteration }}</td>
					<td>{{ $status['step'] }}</td>
					<td>
						@if($status['status'])
							<span class="text-success"><i class="mdi mdi-check-circle-outline"></i> Sudah</span>
						@else
							-
						@endif
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
	{{ $slot ?? '' }}
</div>