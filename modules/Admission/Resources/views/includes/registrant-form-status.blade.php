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

$name = $registrant->user_id == auth()->id() ? 'Anda' : $registrant->user->profile->name
@endphp

@if($registrant->tested_at)
    <div class="alert alert-success bg-success">
        <p><Strong>Selamat!</Strong> <br> Anda telah <strong>diterima</strong> secara resmi sebagai mahasiswa STAI Sunan Pandanaran T.A 2021-2022. Adapun ketetapan penempatan Program Studi pilihan saudara/i akan dimumkan pada bulan Agustus-September 2021 berdasarkan hasil tes tulis dan tes wawancara.</p>
        <a class="btn btn-outline-light" href="{{ route('admission.test.result.print', ['registrant' => $registrant->id]) }}" target="_blank"><i class="mdi mdi-printer"></i> Cetak surat diterima</a>
    </div>
@endif

<div class="alert alert-info">
    <Strong>Informasi!</Strong> <br> Pembayaran untuk pendaftaran berlaku untuk seluruh calon mahasiswa baru sebesar Rp 250.000 ke BRI a.n. <strong>PMB STAISPA</strong> No Rek. <strong>31193-77777-22222</strong> (BRIVA).  <br>
    <a class="alert-link" href="/teknis-pembayaran.jpeg" target="_blank"><u>Klik disini</u></a> untuk melihat tata cara dan teknis pembayaran.
</div>

<div class="card">
	<div class="card-body">
		<h5 class="mb-0">Status pengisian formulir</h5>
		<p><small class="text-muted">Presentase kelengkapan formulir berdasarkan data-data yang wajib dilengkapi</small></p>
		@if($registrant->validated_at)
			<div class="progress" style="height: 30px;">
				<div class="progress-bar progress-bar-striped progress-bar-animated h6 mb-0 bg-success" role="progressbar" style="width: 100%;">Data sudah divalidasi</div>
			</div>
		@else
			<div class="progress" style="height: 30px;">
				<div class="progress-bar progress-bar-striped progress-bar-animated h6 mb-0 {{ $color }}" role="progressbar" style="width: {{ $precentage.'%' }};">{{ $precentage }}%</div>
			</div>
		@endif
	</div>
	@if(count($forms))
		<div class="table-responsive">
			<table class="table table-striped border-bottom mb-0">
				<thead>
					<tr class="bg-dark text-white">
						<th width="1">No.</th>
						<th>Formulir</th>
						<th>Status</th>
						@can('registration', Admission::class)
							@if(!$registrant->validated_at)
								<th>Aksi</th>
							@endif
						@endcan
						@can('update', $registrant)
							<th>Aksi</th>
						@endcan
					</tr>
				</thead>
				<tbody>
					@foreach ($forms as $form)
					<tr>
						<td class="text-center">{{ $loop->iteration }}</td>
						<td nowrap>
							<div>
								{{ $form->name }}
								@if($form->required) <small class="text-danger">({{ $form->required_message ?: 'Wajib dilengkapi' }})</small> @endif
							</div>
							@if($form->description) <small class="text-muted">{{ $form->description }}</small> @endif
						</td>
						<td nowrap>
							@if($form->getStatus($registrant))
								<span class="text-success"><i class="mdi mdi-check-circle-outline"></i> Sudah diisi</span>
							@else
								<span class="text-danger"><i class="mdi mdi-close-circle-outline"></i> Belum lengkap</span>
							@endif
						</td>
						@if($registrant->user_id == auth()->id())
							@if(!$registrant->validated_at)
								<td nowrap class="border-left">
									<a href="{{ route('admission.form.'.$form->route, array_merge(['next' => route('admission.home')], $form->params)) }}">
										@if($form->getStatus($registrant))
											<i class="mdi mdi-eye"></i> Lihat
										@else
											<i class="mdi mdi-pencil"></i> Lengkapi sekarang
										@endif
									</a>
								</td>
							@endif
						@elsecan('update', $registrant)
							<td nowrap class="border-left">
								<a href="{{ route('admission.admin.database.manage.registrants.edit', array_merge(['registrant' => $registrant->id, 'key' => $form->route, 'next' => url()->current()], $form->params)) }}">
									@if($form->getStatus($registrant))
										<i class="mdi mdi-eye"></i> Lihat
									@else
										<i class="mdi mdi-pencil"></i> Lengkapi sekarang
									@endif
								</a>
							</td>
						@endif
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		@can('view', $registrant)
			<div class="card-body">
				@can('registration', Admission::class)
					<p>Jika {{ $name }} telah mengisi seluruh data pendaftaran dengan data yang benar-benar valid, silahkan tekan tombol berikut untuk mengunduh dan mencetak formulir pendaftaran {{ $name }}.</p>
				@endcan
				@if($precentage == 100 || auth()->user()->can('update', $registrant) || $registrant->validated_at)
        		    <p>
        		        <button class="btn btn-link p-0" data-toggle="modal" data-target="#result-modal"><i class="mdi mdi-printer"></i> Cetak seluruh data pendaftaran</button>
        		    </p>
				    <div class="alert alert-success">
				        Anda telah mengisi seluruh data pendaftaran dengan benar, salin teks berikut lalu kirimkan ke tautan WhatsApp berikut ini. <br>
				        <strong>VERIFIKASI - {{ $registrant->user->profile->full_name. ' - '.$registrant->kd }}</strong> <br>
				    </div>
					<!--<button class="btn btn-success" data-toggle="modal" data-target="#result-modal"><i class="mdi mdi-printer"></i> Cetak seluruh data pendaftaran</button>-->
					<a class="btn btn-success" href="https://chat.whatsapp.com/CAfbhIxNaQUJKmVD1bNcEG"><i class="mdi mdi-whatsapp"></i> Link grup WhatsApp</a>
					@push('script')
						<div id="result-modal" class="modal" data-backdrop="static">
							<div class="modal-dialog modal-lg">
								<div class="modal-content">
									<div class="modal-body p-0">
										<iframe id="result-frame" height="600" class="w-100 m-0 border-0"></iframe>
									</div>
									<div class="modal-footer">
										<a class="btn btn-success" href="{{ route('admission.form', ['registrant' => $registrant->id]) }}" target="_blank">Download</a>
										<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
									</div>
								</div>
							</div>
						</div>
						<script type="text/javascript">
							$(function () {
								$('#result-modal').on('show.bs.modal', (e) => {
									$('#result-modal').block({message: ''})
									$('#result-frame').attr('src', '{{ route('admission.form', ['registrant' => $registrant->id]) }}')
									$('#result-frame').on('load', (e) => {
										$('#result-modal').unblock({message: ''})
									})
								})
							})
						</script>
					@endpush
				@else
					<p class="text-danger">{{ $name }} belum melengkapi pengisian formulir</p>
					<button class="btn btn-secondary" disabled><i class="mdi mdi-printer"></i> Cetak formulir pendaftaran</button>
				@endif
				@can('update', $registrant)
					<!--<a class="btn btn-secondary" href="{{ route('admission.admin.database.manage.registrants.index') }}"><i class="mdi mdi-arrow-left-circle"></i> Kembali</a>-->
				@endcan
			</div>
		@endcan
		{{ $slot ?? '' }}
	@else
		<div class="card-body border-top text-danger">
			Mohon maaf, formulir pendaftaran belum diatur, silahkan hubungi Administrator.
		</div>
	@endif
</div>