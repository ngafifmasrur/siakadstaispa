@extends('admission::layouts.default')

@section('subtitle', 'Riwayat pendidikan - ')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-lg-8 offset-lg-2">
				<h2 class="mb-0"><a class="text-decoration-none small" href="{{ request('next', route('admission.home')) }}"><i class="icon-arrow-left-circle"></i></a> Riwayat pendidikan </h2>
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="col-lg-8 offset-lg-2">
			    <p>Riwayat pendidikan digunakan untuk kelengkapan administrasi.</p>
			    <div class="card">
			        <div class="card-body">
			            <table class="w-100">
			            	<tbody>
			            		@forelse($studies as $study)
			            		<tr>
			            			<td>
			            				<p class="mb-4">
			            					<span class="badge badge-dark">{{ $study->grade->name }}</span><br>
			            					<strong>{{ $study->name }}</strong> @if($study->npsn) (NPSN: {{ $study->npsn }}) @endif<br>
			            					{{ $study->regional }} <br>
			            					<span class="text-muted">Dari {{ $study->from }} sampai {{ date('Y') == $study->to ? 'sekarang' : $study->to }}</span>
			            				</p>
			            			</td>
			            			<td class="text-right align-top">
			            				<form class="form-block" action="{{ route('admission.form.studies.destroy', ['study' => $study->id, 'next' => url()->current()]) }}" method="POST"> @csrf @method('DELETE')
			            					<a href="{{ route('admission.form.studies.edit', ['study' => $study->id, 'next' => url()->current()]) }}">Edit</a> &bull;
			            					<a href="javascript:;" class="text-danger" onclick="if (confirm('Apakah Anda yakin?')) this.parentNode.submit()">Hapus</a>
			            				</form>
			            			</td>
			            		</tr>
			            		@empty
			            		<tr>
			            			<td><p>Tidak ada data riwayat pendidikan, silahkan tekan tombol dibawah untuk menambahkan data riwayat pendidikan.</p></td>
			            		</tr>
			            		@endforelse
			            	</tbody>
			            </table>
			            <a href="{{ route('admission.form.studies.create', ['next' => url()->current()]) }}" class="btn btn-success">Tambah riwayat pendidikan</a>
			            <a class="btn btn-secondary" href="{{ route('admission.home') }}">Kembali</a>
			        </div>
			    </div>
			</div>
		</div>
	</div>
@endsection