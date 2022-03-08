@extends('admission::layouts.default')

@section('subtitle', 'Riwayat organisasi - ')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-lg-8 offset-lg-2">
				<h2 class="mb-0"><a class="text-decoration-none small" href="{{ request('next', route('admission.home')) }}"><i class="icon-arrow-left-circle"></i></a> Riwayat organisasi </h2>
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="col-lg-8 offset-lg-2">
			    <p>Riwayat organisasi digunakan untuk kelengkapan administrasi.</p>
			    <div class="card">
			    	<div class="card-body">
			    	    <h4 class="mb-0">Riwayat organisasi</h4>
			    	</div>
			    	<div class="table-responsive">
			    	    <table class="table table-striped border-bottom mb-0">
			    	        <thead>
			    	            <tr class="bg-dark text-white">
			    	                <th width="1">No.</th>
			    	                <th>Nama</th>
			    	                <th>Jenis</th>
			    	                <th>Tahun</th>
			    	                <th>Jabatan</th>
			    	                <th>Berkas</th>
			    	                <th>Aksi</th>
			    	            </tr>
			    	        </thead>
			    	        <tbody>
			    	            @forelse ($organizations as $i => $organization)
			    	                <tr>
			    	                    <td nowrap> {{ $loop->iteration }} </td>
			    	                    <td nowrap> {{ $organization->name }} </td>
			    	                    <td nowrap> {{ $organization->type->name}} </td>
			    	                    <td nowrap> {{ $organization->year }} ({{ $organization->duration ?: 0 }} tahun) </td>
			    	                    <td nowrap> {{ $organization->position->name}} </td>
			    	                    <td nowrap class="align-middle py-2">
			    	                        @if ($organization->file)
			    	                            <a href="{{ Storage::url($organization->file) }}" target="_blank"><i class="icon-eye"></i> Lihat</a>
			    	                        @else
			    	                            -
			    	                        @endif
			    	                    </td>
			    	                    <td nowrap class="align-middle py-2 border-left">
			    	                        <form class="form-block" action="{{ route('admission.form.organizations.destroy', ['organization' => $organization->id, 'next' => url()->current()]) }}" method="POST"> @csrf @method('DELETE')
			    	                            <a href="javascript:;" class="text-danger" onclick="if (confirm('Apakah Anda yakin?')) this.parentNode.submit()"><i class="icon-trash"></i> Hapus</a>
			    	                        </form>
			    	                    </td>
			    	                </tr>
			    	            @empty
			    	                <tr><td colspan="7" class="text-center"><i>{{ auth()->user()->id == $registrant->user->id ? 'Anda' : $registrant->user->profile->full_name }} tidak memiliki riwayat organisasi.</i></td></tr>
			    	            @endforelse
			    	        </tbody>
			    	    </table>
			    	</div>
			    	<div class="card-body">
			    	    <a href="{{ route('admission.form.organizations.create', ['next' => url()->current()]) }}" class="btn btn-success">Tambah riwayat organisasi</a>
			    	    <a class="btn btn-secondary" href="{{ route('admission.home') }}">Kembali</a>
			    	</div>
			    </div>
			</div>
		</div>
	</div>
@endsection