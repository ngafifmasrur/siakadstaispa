@extends('layouts.pdf')

@section('title', 'FORMULIR-PENDAFTARAN-'.$registrant->kd)

@section('kop', 'PENERIMAAN MAHASISWA BARU '.$registrant->admission->period->name)
@section('kop-sub', strtoupper($registrant->admission->period->instance->long_name))

@php
	
	$user = $registrant->user;
	$files = $registrant->admission->files->load([
					'registrants' => function($query) use ($registrant) { 
						$query->where('registrant_id', $registrant->id); 
					}
				]);

@endphp

@section('content')
<main>
	<div style="padding: 10px; border: 1px solid #ccc; border-radius: 10px; margin-bottom: 20px;">
		<table>
			<tr>
				<td width="1" style="vertical-align: middle;">
					<img class="rounded" src="{{ $registrant->avatar ? Storage::url($registrant->avatar) : asset('assets/img/img-blank-3-4.png') }}" style="height: 3cm;" align="center">
				</td>
				<td style="padding-left: 15px; vertical-align: middle;">
					<p class="muted" style="margin-bottom: 10px;">{{ $registrant->admission->full_name }} / {{ $registrant->kd }}</p>
					@if(strlen($user->profile->name) < 26 )
						<h1 style="margin-bottom: 2px;">{{ $user->profile->name }}</h1>
					@else
						<h2 style="margin-bottom: 5px;">{{ $user->profile->name }}</h2>
					@endif
					<p>{{ strtoupper($user->profile->pdob) }}</p>
					<p>Pilihan program studi : <span style="padding-left: 10px;">1.</span> <strong>{{ $registrant->major1_name ?? '-' }}</strong> <span style="padding-left: 20px;">2.</span> <strong>{{ $registrant->major2_name ?? '-' }}</strong></p>
				</td>
			</tr>
		</table>
	</div>

    <div style="position:absolute; top: 160px;">
        @php
    		$personal = [
    			'IDENTITAS' => [
    				'Nama lengkap' =>  $user->profile->full_name,
    				'Tempat, tanggal lahir' =>  $user->profile->pdob,
    				'NIK' =>  $user->profile->nik ?? null,
    				'No.KK' =>  $user->profile->nokk ?? null,
    				'NISN' =>  $user->profile->nisn ?? null,
    				'Jenis kelamin' =>  $user->profile->sex !== null ? config('web.references.sexes')[$user->profile->sex] : null,
    				'Golongan darah' =>  $user->profile->blood !== null ? config('web.references.bloods')[$user->profile->blood] : null,
    				'Kewarganegaraan' =>  $user->profile->country->name ?? null
    			],
    			'KONTAK' => [
    				'No. Telp/HP' => $user->phone->number.($user->phone->whatsapp ? ' (WA)' : ''),
    				'Alamat e-mail' => $user->email->address,
    				'Alamat' => $user->address->branch,
    				'Regional' => $user->address->regional,
    				'Kode pos' => $user->address->postal,
    			]
    		];
    
    		$ttdparent = array_filter([
    			!$user->father->is_dead ? $user->father->name : null,
    			!$user->mother->is_dead ? $user->mother->name : null,
    		]);
    
    		$parent = [
    			'INFORMASI AYAH' => [
    				'NIK ayah' => $user->father->nik ?: null,
    				'Nama ayah' => ($user->father->is_dead ? 'ALM. ' : '').$user->father->name ?? null,
    				'Tempat, tanggal lahir' => $user->father->pdob ?? null,
    				'Pendidikan terakhir' => $user->father->grade->name ?? null,
    				'Pekerjaan' => $user->father->employment->name ?? null,
    				'Penghasilan/bulan' => $user->father->salary->name ?? null,
    			],
    			'INFORMASI IBU' => [
    				'NIK ibu' => $user->mother->nik ?: null,
    				'Nama ibu' => ($user->mother->is_dead ? 'ALM. ' : '').$user->mother->name ?? null,
    				'Tempat, tanggal lahir' => $user->mother->pdob ?? null,
    				'Pendidikan terakhir' => $user->mother->grade->name ?? null,
    				'Pekerjaan' => $user->mother->employment->name ?? null,
    				'Penghasilan/bulan' => $user->mother->salary->name ?? null,
    			],
    		];
    	@endphp
    
    	<table style="height: 755px;">
    		<tr>
    			<td width="35%" style="border-right: 1px solid #ccc; padding-right: 10px;">
    				@foreach($personal as $t => $d)
    					<fieldset>
    						<legend>{{ $t }}</legend>
    						@foreach($d as $k => $v)
    							<div class="form">
    								<p class="label">{{ $k }}</p>
    								<h4>
    									@if($v)
    										{{ $v }}
    									@else
    										<span class="muted">Belum diisi</span>
    									@endif
    								</h4>
    							</div>
    						@endforeach
    					</fieldset>
    					@if(!$loop->last) <hr style="margin: 20px 0 30px 5px;"> @endif
    				@endforeach
    			</td>
    			<td width="65%" style="padding-left:10px;">
    				@foreach($parent as $t => $d)
    					<fieldset>
    						<legend>{{ $t }}</legend>
    						<br>
    						<table>
    							@foreach($d as $k => $v)
    								<tr>
    									<td width="120" class="muted">{{ $k }}</td>
    									<td width="5" style="padding:0 5px;">:</td>
    									<td>
    										<h4>
    											@if($v)
    												{{ $v }}
    											@else
    												<span class="muted">Belum diisi</span>
    											@endif
    										</h4>
    									</td>
    								</tr>
    							@endforeach
    						</table>
    					</fieldset>
    					@if(!$loop->last) <hr style="margin: 20px 5px 30px 0"> @endif
    				@endforeach
    				<hr style="margin: 20px 5px 30px 0">
    				<fieldset>
    					<legend> RIWAYAT PENDIDIKAN</legend>
    					<br>
    					<table>
    						@forelse($user->studies->take(4) as $study)
    							<tr>
    								<td nowrap style="padding:0 10px 0 0;" width="80">
    									<strong>{{ $study->range }}</strong>
    								</td>
    								<td style="padding:0 10px;">
    									<strong>{{ $study->name }}</strong>
    								</td>
    							</tr>
    						@empty
    							<tr>
    								<td class="muted"><i>Tidak ada riwayat pendidikan</i></td>
    							</p>
    						@endforelse
    					</table>
    				</fieldset>
    			</td>
    		</tr>
    	</table>
        <div class="center" style="position: absolute;bottom: 1.75cm; padding: 5px; border:1px solid #000">
            <p style="line-height: 6pt;"><small>PASTIKAN DATA TELAH TERISI DENGAN BENAR, SEMAKIN VALID DATA AKAN LEBIH MEMPERCEPAT PROSES SELEKSI MAHASISWA. <br> DATA DI ATAS MENJADI ACUAN UNTUK PEMBUATAN KTM SETELAH ANAK DINYATAKAN DITERIMA</small></p>
        </div>
    	<div style="position: absolute;bottom: 3.5cm; padding-left: 10px;">
    		<table width="100%">
    			<tr>
    				<td width="35%"></td>
    				<td width="65%" class="center">
    					<table>
    						<tr>
    							<td colspan="2">
    								Dengan ini saya menyatakan sanggup hadir melaksanakan tes di lokasi pendaftaran sesuai waktu tes yang telah saya pilih,
    							</td>
    						</tr>
    						<tr>
    							<td width="50%">
    								<div>&nbsp;</div>
    								<div style="height: 100px; border-bottom: 1px dotted #000; margin: 0px 20px;">Orang tua/wali</div>
    								({!! count($ttdparent) ? join('/', $ttdparent) : str_repeat('&nbsp;', 40) !!})
    							</td>
    							<td width="50%">
    								<div>Sleman, {{ strftime('%d %B %Y') }}</div>
    								<div style="height: 100px; border-bottom: 1px dotted #000; margin: 0px 20px;">Calon mahasiswa</div>
    								({{ $user->profile->full_name }})
    							</td>
    						</tr>
    					</table>
    				</td>
    			</tr>
    		</table>
    	</div>
    </div>
</main>

@php
$admission = [
	'DETAIL PENDAFTARAN' => [
		'Tahun' =>  $registrant->admission->period->name,
		'Jalur pendaftaran' =>  $registrant->admission->name,
		'Nama' =>  $user->profile->name,
		'Tempat, tanggal lahir' =>  $user->profile->pdob,
		'Nomor pendaftaran' =>  $registrant->kd,
		'Tanggal tes' =>  $registrant->test_at ? strtoupper($registrant->test_at->formatLocalized('%A, %d %B %Y')) : null,
		'Sesi tes' =>  $registrant->session->name. ' ('.$registrant->session->range.')',
		'Terdaftar pada' =>  $registrant->created_at->formatLocalized('%d %B %Y pukul %H:%M'),
	]
];
@endphp
@endsection