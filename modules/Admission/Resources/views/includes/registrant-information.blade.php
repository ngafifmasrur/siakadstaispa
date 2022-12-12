@php
	$admission = $registrant->admission;
	$user = $registrant->user;

	$lists = [
		'Jalur registrasi'			=> $admission->name.' '.$admission->period->name,
		'No pendaftaran'			=> $registrant->kd,
		'NIK'						=> $user->profile->nik ?: '-',
		'Nama lengkap'				=> $user->profile->full_name,
		'Jenis kelamin'				=> $user->profile->sex_name ?? '-',
		'Tempat, tanggal lahir'		=> $user->profile->pob.', '.strtoupper($user->profile->dob->formatLocalized('%d %B %Y')),
		'No telp'					=> $user->nomor_hp ??  '-',
		'Alamat e-mail'				=> $user->email->address ?? '-',
		'Waktu mendaftar'			=> $registrant->created_at->formatLocalized('%d %B %Y pukul %H:%M'),
		'Pilihan program studi'		=> ($registrant->major_1_name || $registrant->major_2_name) ? ($registrant->major_1_name.'/'.$registrant->major_2_name) : '-'
	];
	if(isset($simple)) {
		unset($lists['NIK']);
		unset($lists['No telp']);
		unset($lists['Alamat e-mail']);
		unset($lists['Waktu mendaftar']);
	}
@endphp

<div class="card">
	<div class="card-body">
		<h5 class="mb-4">Informasi calon mahasiswa</h5>
		<ul class="list-unstyled mb-0">
			@foreach($lists as $key => $list)
				<li @if(!$loop->last) class="mb-2" @endif>
					<span class="font-weight-bold">{{ $key }}</span> <br>
					{!! $list !!}
				</li>
			@endforeach
		</ul>
	</div>
	@if($registrant->files()->exists())
	    <div class="list-group list-group-flush dropdown dropright">
	        @if($user->phone->whatsapp)
	            <a class="list-group-item list-group-item-action text-success" href="https://wa.me/{{ $user->phone->number }}" target="_blank">Kirim whatsapp</a>
	        @endif
    		<a class="list-group-item list-group-item-action dropdown-toggle text-success" href="javascript:;" role="button" id="registrant-files-dropdown" data-toggle="dropdown">
    			Berkas
    		</a>
    		<div class="dropdown-menu" aria-labelledby="registrant-files-dropdown">
    			@foreach($registrant->files as $__file)
    			    <a class="dropdown-item text-success" href="{{ Storage::url($__file->pivot->file) }}" target="_blank"><i class="icon-cloud-download"></i> {{ $__file->name }}</a>
    			@endforeach
    		</div>
    	</div>
	@endif
</div>