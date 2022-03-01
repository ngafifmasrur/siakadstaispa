@extends('layouts.pdf')

@section('title', 'LAPORAN-KUOTA')

@section('content')
<main>
	<h4 class="center"><u>LAPORAN KUOTA</u></h4>
	<p class="center">Per <strong>{{ strftime('%A, %d %B %Y pukul %H:%M WIB', time()) }}</strong></p>
	<br>
	<table class="table table-bordered">
		<thead>
			<tr>
				<th>No</th>
				<th>Status</th>
				@foreach(config('admission.sex-transform') as $sex)
					<th class="center">{{ $sex }}</th>
				@endforeach
			</tr>
		</thead>
		<tbody>
			@foreach($detailQuota as $label => $details)
			<tr>
				<td>{{ $loop->iteration }}</td>
				<td>{{ $label }}</td>
				@foreach($details as $detail)
					<td class="center">{{ $detail }}</td>
				@endforeach
			</tr>
			@endforeach
		</tbody>
	</table>

</main>
@endsection