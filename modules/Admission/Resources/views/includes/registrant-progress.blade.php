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

    $paymentDetails  = \Modules\Admission\Models\CostInformation::where('name', 'Rincian Pembayaran')
                        ->first()->description ?? null;

    $educationCost   = \Modules\Admission\Models\CostInformation::where('name', 'Biaya Pendidikan')
                        ->first()->description ?? null;

    $monthlyCost   = \Modules\Admission\Models\CostInformation::where('name', 'Biaya Bulanan Pesantren')
                        ->first()->detail ?? null;


    $costInformations = \Modules\Admission\Models\CostInformation::whereNotIn('name', [
                            'Rincian Pembayaran',
                            'Biaya Pendidikan'
                        ])->get();

@endphp


@if ($registrant->is_saman == 1)
	@php
	$statusses = [
		['step' => 'Terdaftar', 'status' => $precentage == 100 ? true : false],
		['step' => 'Tes CBT', 'status' => $status_cbt],
		['step' => 'Pilih Tanggal kedatangan', 'status' => $registrant->tanggal_kedatangan ? true : false],
		['step' => 'Wawancara', 'status' => $registrant->status_wawancara == 1 ? true : false],
		[
            'step' => 'Unduh Surat Keterangan Diterima',
            'status' => (
                $precentage == 100 &&
                $registrant->status_wawancara == 1 &&
                $status_cbt &&
                $registrant->verified_at
            )
        ],
	];
	@endphp
@else
@php
	$statusses = [
		['step' => 'Terdaftar', 'status' => $precentage == 100 ? true : false],
		['step' => 'Tes CBT', 'status' => $status_cbt],
		['step' => 'Pilih Tanggal kedatangan', 'status' => $registrant->tanggal_kedatangan ? true : false],
		[
            'step' => 'Unduh Surat Keterangan Diterima',
            'status' => (
                $precentage == 100 &&
                $status_cbt &&
                $registrant->verified_at
            )
        ],
		['step' => 'Pembayaran', 'status' => $registrant->paid_off_at],
	];
	@endphp
@endif

<div class="card">

	<div class="card-body">
		<h5 class="mb-0">Status tahap pendaftaran</h5>
	</div>
	<div class="table-responsive">
		<table class="table table-striped border-bottom mb-0" aria-describedby="Tahapan">
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
		{!! $paymentDetails !!}
	</div>
	<div class="table-responsive">
		<table class="table table-striped border-bottom mb-0">
				<tr class="bg-dark text-white">
					<th colspan="2">Biaya Penddikan</th>
				</tr>
				<tr>
					<td colspan="2">
                        {!! $educationCost !!}
                    </td>
				</tr>
				<tr class="bg-dark text-white">
					<th colspan="2">Biaya Pesantren</th>
				</tr>

                @foreach ($costInformations as $item)
				<tr>
					<td>{{ $item->name }}</td>
					<td>{{ numToRupiah($item->detail) }}</td>
				</tr>
                @endforeach

				<tr>
					<td class="font-weight-bold">Total</td>
					<td  class="font-weight-bold">{{ numToRupiah($costInformations->sum('detail')) }}</td>
				</tr>
                <tr>
					<td class="font-weight-bold">Total biaya bulanan pesantren</td>
					<td class="font-weight-bold">{{ numToRupiah($monthlyCost ?? 0) }}</td>
				</tr>
		</table>
	</div>
</div>
@endif
