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
		['step' => 'Unduh Surat Keterangan Diterima', 'status' => ($precentage == 100 && $registrant->status_wawancara == 1 && $status_cbt)],
	];
	@endphp
@else
@php
	$statusses = [
		['step' => 'Terdaftar', 'status' => $precentage == 100 ? true : false],
		['step' => 'Tes CBT', 'status' => $status_cbt],
		['step' => 'Pilih Tanggal kedatangan', 'status' => $registrant->tanggal_kedatangan ? true : false],
		['step' => 'Unduh Surat Keterangan Diterima', 'status' => ($precentage == 100 && $status_cbt)],
		['step' => 'Pembayaran', 'status' => $registrant->paid_off_at],
	];
	@endphp
@endif

<div class="card">

	<div class="card-body">
		<h5 class="mb-0">Status tahap pendaftaran
		</h5>
		{{-- <p class="mb-0"><small class="text-muted">Saat ini status Anda adalah <strong>{{ $registrant->step_status }}</strong></small></p> --}}
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

@if ($registrant->is_saman == 0 && $precentage == 100)
<div class="card">
	<div class="card-body">
		<h5 class="mb-0">Rincian Pembayaran
		</h5>
		<br> Pembayaran untuk pendaftaran berlaku untuk seluruh calon mahasiswa baru sebesar <strong>Rp 3.000.000</strong> ke BRI a.n. <strong>PMB STAISPA</strong> No Rek. <strong>31193-77777-22222</strong> (BRIVA).  <br>
		<a class="alert-link" href="/teknis-pembayaran.jpg" target="_blank"><u>Klik disini</u></a> untuk melihat tata cara dan teknis pembayaran.
		{{-- <p class="mb-0"><small class="text-muted">Saat ini status Anda adalah <strong>{{ $registrant->step_status }}</strong></small></p> --}}
	</div>
	<div class="table-responsive">
		<table class="table table-striped border-bottom mb-0">
				<tr class="bg-dark text-white">
					<th colspan="2">Biaya Penddikan</th>
				</tr>
				<tr>
					<td colspan="2">Biaya pendidikan STAISPA menggunakan sistem Uang Kuliah Tunggal (UKT) sebesar <strong>Rp. 1.700.000</strong> dibayarkan setiap semester</td>
				</tr>
				<tr class="bg-dark text-white">
					<th colspan="2">Biaya Pesantren</th>
				</tr>
				<tr>
					<td>Pemakaian kasur selama di pesantren</td>
					<td>Rp. 250.000</td>
				</tr>
				<tr>
					<td>Pemakaian ranjang selama di pesantren</td>
					<td>Rp. 500.000</td>
				</tr>
				<tr>
					<td>Pemakaian almari selama di pesantren</td>
					<td>Rp. 200.000</td>
				</tr>
				<tr>
					<td>Syahriah Pesantren</td>
					<td>Rp. 50.000</td>
				</tr>
				<tr>
					<td>Makan 3x dan penyedian air minum</td>
					<td>Rp. 300.000</td>
				</tr>
				<tr>
					<td class="font-weight-bold">Total</td>
					<td  class="font-weight-bold">Rp. 1.300.000</td>
				</tr>
				<tr>
					<td class="font-weight-bold">Total biaya bulanan pesantren</td>
					<td class="font-weight-bold">Rp. 350.000</td>
				</tr>
		</table>
	</div>
</div>
@endif
