@php
$statusses = [
	['step' => 'Terdaftar', 'status' => 'Terdaftar', 'datetime' => $registrant->created_at, 'key' => null],
	['step' => 'Verifikasi', 'status' => 'Terverifikasi', 'datetime' => $registrant->verified_at, 'key' => 'verified_at'],
	['step' => 'Validasi', 'status' => 'Data valid', 'datetime' => $registrant->validated_at, 'key' => 'validated_at'],
	['step' => 'Perjanjian', 'status' => 'Sudah', 'datetime' => $registrant->agreement_at, 'key' => 'agreement_at'],
	['step' => 'Pembayaran', 'status' => 'Lunas pembayaran', 'datetime' => $registrant->paid_off_at, 'key' => 'paid_off_at'],
	['step' => 'Penerimaan', 'status' => 'Telah diterima', 'datetime' => $registrant->accepted_at, 'key' => 'accepted_at'],
];
@endphp

<div class="card">
	<div class="card-body">
		<h5 class="mb-0">Status tahap pendaftaran</h5>
		<p class="mb-0"><small class="text-muted">Saat ini status Anda adalah <strong>{{ $registrant->step_status }}</strong></small></p>
	</div>
	<div class="table-responsive">
		<table class="table table-striped border-bottom mb-0">
			<thead>
				<tr class="bg-dark text-white">
					<th width="1">No.</th>
					<th>Tahap pendaftaran</th>
					<th>Status</th>
					<th>Waktu</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($statusses as $status)
				<tr>
					<td class="text-center">{{ $loop->iteration }}</td>
					<td>{{ $status['step'] }}</td>
					<td>
						@if($status['datetime'])
							<span class="text-success"><i class="mdi mdi-check-circle-outline"></i> {{ $status['status'] }}</span>
						@else
							-
						@endif
					</td>
					<td>
						{{ $status['datetime'] ?? '-' }}
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
	{{ $slot ?? '' }}
</div>