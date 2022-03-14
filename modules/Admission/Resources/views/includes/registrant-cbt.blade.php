<div class="card">
	<div class="card-body">
		<h5 class="mb-0">Tes CBT</h5>
	</div>
	<div class="table-responsive">
		<table class="table table-striped border-bottom mb-0">
			<thead>
				<tr class="bg-dark text-white">
					<th width="1">No.</th>
					<th>Kode Mapel</th>
					<th>Mapel</th>
					<th>Waktu</th>
					<th>Jumlah Soal</th>
					<th>Aksi</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($admission_cbt as $item)
				<tr>
					<td class="text-center">{{ $loop->iteration }}</td>
					<td>{{ $item->kode_mapel }}</td>
					<td>{{ $item->mapel }}</td>
					<td>{{ $item->durasi/60 }} Menit</td>
					<td>{{ $item->jumlah_acakan_soal }}</td>
					<td>
					@if ($item->status_registrant_cbt == 0)
						<a class="btn btn-primary" href="{{ route('admission.cbt', $item->id)}}">Kerjakan</a>
					@elseif($item->status_registrant_cbt == 1)
						<a class="btn btn-primary" href="{{ route('admission.cbt', $item->id)}}">Lanjut Kerjakan</a>
					@else
						<span class="text-success" href="#">Selesai Dikerjakan</span>
                    @endif
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>

