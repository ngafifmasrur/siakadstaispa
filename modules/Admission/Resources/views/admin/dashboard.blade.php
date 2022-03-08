@extends('admission::admin.layouts.admin')

@section('subtitle', 'Dasbor - ')

@section('breadcrumb')
    <li class="breadcrumb-item">Admin</li>
    <li class="breadcrumb-item active">Dasbor</li>
@endsection

@section('content')
	<div class="row">
		<div class="col-md-8">
			<div class="jumbotron bg-dark text-white">
				<h1>Assalamualaikum {{ auth()->user()->profile->full_name }}!</h1>
				<div>di {{ config('admission.head.title') }}</div>
			</div>

			<div class="card-group mb-4">
			    @foreach($statistics as $route => $statistic)
			        <div class="card">
			            <div class="card-body">
			                <table class="table mb-0 h-100">
			                    <tr>
			                        <td class="p-0 border-0">
			                            <h1 class="mb-0">{{ $statistic['data'] }}</h1>
			                            <small class="text-muted font-weight-bold">{{ $statistic['title'] }}</small>
			                        </td>
			                        <td width="50" class="p-0 border-0"><span class="mdi mdi-{{ $statistic['icon'] }} mdi-36px text-{{ $statistic['color'] }}"></span></td>
			                    </tr>
			                </table>                            
			                @if(Route::has($route))
			                    <a href="{{ route($route) }}">Lihat selengkapnya &raquo;</a>
			                @endif
			            </div>
			        </div>
			    @endforeach
			</div>
            
            <div class="card">
            	<div class="card-header">Rincian kuota berdasarkan status calon mahasiswa</div>
            	<div class="table-responsive">
            		<table class="table mb-0 table-hover">
            			<thead class="thead-dark">
            				<tr>
            					<th>No</th>
            					<th>Status</th>
            					@foreach(config('admission.sex-transform') as $sex)
            						<th>{{ $sex }}</th>
            					@endforeach
            					<th>Jumlah</th>
            				</tr>
            			</thead>
            			<tbody>
            				@foreach($detailQuota as $label => $details)
            				    @php
            				        $xsum = 0;
            				    @endphp
	            				<tr>
	            					<td>{{ $loop->iteration }}</td>
	            					<td>{{ $label }}</td>
            						@foreach($details as $detail)
                						@php
                    				        $xsum += $detail;
                    				    @endphp
            							<td>{{ $detail }}</td>
            						@endforeach
            						<td>{{ $xsum }}</td>
	            				</tr>
            				@endforeach
            			</tbody>
            		</table>
            	</div>
            </div>

			<div class="card">
                <div class="card-header">Jumlah pendaftar perhari</div>
                <div class="card-body">
                	@if($registeredPerDay)
                    	<canvas id="getRegisteredPerDay" class="w-100" height="300"></canvas>
                    @else
						Tidak ada jalur pendaftaran yang dibuka
                    @endif
                </div>
            </div>
			
			<div class="card">
				<div class="card-header">Jumlah peserta tes per tanggal tes</div>
				<div class="table-responsive">
					<table class="table mb-0">
						<tbody>
							@foreach($testDay as $admissions)
								<tr>
									<td nowrap class="py-1 table-info">{{ $admissions['name'] }}</td>
									<td nowrap class="py-1 table-info text-center">Jumlah</td>
									@forelse($admissions['admission']->sessions as $session)
									    <td nowrap class="py-1 table-info text-center">{{ $session->name.' '.$session->range }}</td>
									@endforeach
								</tr>
								@forelse($admissions['data'] as $day => $count)
									<tr>
										<td>{{ strftime('%A, %d %B %Y', strtotime($day)) }}</td>
										<td class="text-center">{{ $count }}</td>
										@foreach($admissions['admission']->sessions as $session)
    									    <td class="text-center">{{ $admissions['admission']->registrants()->whereDate('test_at', $day)->where('session_id', $session->id)->count() }}</td>
    									@endforeach
									</tr>
								@empty
									<tr>
										<td colspan="2" class="text-muted">Tidak ada peserta tes</td>
									</tr>
								@endforelse
							@endforeach
						</tbody>
					</table>
				</div>
			</div>

		</div>
		<div class="col-md-4">
		    <div class="card">
                <div class="card-header">Jumlah peminat 1</div>
                <div class="table-responsive">
                    <table class="table table-striped table-hover mb-0">
                    	<thead class="thead-dark">
                    		<tr>
                    			<th>Prodi</th>
                    			<th>Jumlah</th>
                    		</tr>
                    	</thead>
                    	<tbody>
                    		@foreach($majors as $major)
                    			<tr>
                    				<td>{{ $major->major_1_name ?? 'Belum isi' }}</td>
                    				<td>{{ $major->total ?? 0 }} mahasiswa</td>
                    			</tr>
                    		@endforeach
                    	</tbody>
                    </table>
                </div>
            </div>
		    <div class="card">
                <div class="card-header">Jumlah peminat 2</div>
                <div class="table-responsive">
                    <table class="table table-striped table-hover mb-0">
                    	<thead class="thead-dark">
                    		<tr>
                    			<th>Prodi</th>
                    			<th>Jumlah</th>
                    		</tr>
                    	</thead>
                    	<tbody>
                    		@foreach($second_majors as $major)
                    			<tr>
                    				<td>{{ $major->major_2_name ?? 'Belum isi' }}</td>
                    				<td>{{ $major->total ?? 0 }} mahasiswa</td>
                    			</tr>
                    		@endforeach
                    	</tbody>
                    </table>
                </div>
            </div>
			<div class="card">
                <div class="card-header">Jumlah pendaftar per jeniskelamin</div>
                <div class="card-body">
                	@forelse($registrantPerSex as $admission)
                		<h5>{{ $admission['name'] }}</h5>
                    	@if($admission['bool'])
                    		<div class="alert alert-secondary">
                    			<canvas id="getRegistrantPerSex-{{ $admission['id'] }}" class="w-100" height="100"></canvas>
                    		</div>
                    	@else
                    		<span class="text-muted">Tidak ada data</span>
                    	@endif
                    	@if(!$loop->last) <hr> @endif
                    @empty
						Tidak ada jalur pendaftaran yang dibuka
                    @endforelse
                </div>
            </div>
		</div>
	</div>
@endsection

@push('script')
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.bundle.min.js"></script>
	<script>
		$(() => {
			new Chart($('#getRegisteredPerDay'), {
			    type: 'line',
			    data: {!! $registeredPerDay !!}
			});

			@forelse($registrantPerSex as $admission)
				@if($admission['bool'])
					new Chart($('#getRegistrantPerSex-{{ $admission['id'] }}'), {
					    type: 'doughnut',
					    data: {!! $admission['value'] !!},
					    options: {
					    	responsive: true,
					    	legend: {
	    						position: 'right',
	    					},
					    }
					});
				@endif
		    @empty @endforelse
		})
	</script>
@endpush