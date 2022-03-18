@extends('layouts.pdf')

@section('title', 'FORMULIR-PENDAFTARAN-'.$registrant->kd)

@section('kop', 'PENERIMAAN MAHASISWA BARU '.$registrant->admission->period->name)
@section('kop-sub', strtoupper($registrant->admission->period->instance->long_name))

@section('content')
<main>
	<div style="padding: 10px; border: 1px solid #ccc; border-radius: 10px; margin-bottom: 20px;">
		<table>
			<tr>
				<td width="1" style="vertical-align: middle;">
					<img class="rounded" src="{{ $gambar }}" style="height: 3cm;" align="center">
				</td>
				<td style="padding-left: 15px; vertical-align: middle;">
					<p class="muted" style="margin-bottom: 10px;">{{ $registrant->admission->full_name }} / {{ $registrant->kd }}</p>
					@if(strlen($user->profile->name) < 26 )
						<h1 style="margin-bottom: 2px;">{{ $user->profile->name }}</h1>
					@else
						<h2 style="margin-bottom: 5px;">{{ $user->profile->name }}</h2>
					@endif
					<p>{{ strtoupper($user->profile->pdob) }}</p>
					<p>Pilihan program studi : <span style="padding-left: 10px;"></span> <strong>{{ $registrant->major1_name ?? '-' }}</strong></p>
				</td>
			</tr>
		</table>
	</div>

    <div style="position:absolute; top: 160px;">
    
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
    					<legend> NILAI TEST CBT</legend>
    					<br>
    					<table>
								<tr>
									<td style="padding:0 10px;">
										<strong>Mapel</strong>
									</td>
									<td style="padding:0 10px;">
										<strong>Skor</strong>
									</td>
								</tr>
    						@forelse($cbts as $cbt)
    							<tr>
    								<td style="padding:0 10px;">
    									{{ $cbt->admission_cbt->mapel }}
    								</td>
    								<td style="padding:0 10px;">
    									{{ $cbt->total_skor }}
    								</td>
    							</tr>
    						@empty
    							<tr>
    								<td class="muted"><i>Tidak test yang dikerjakan</i></td>
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

    </div>
</main>

@endsection