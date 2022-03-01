@extends('admission::admin.layouts.admin')

@section('subtitle', 'Kelola calon mahasiswa baru - ')

@section('breadcrumb')
	<li class="breadcrumb-item">Pangkalan data</li>
	<li class="breadcrumb-item">Kelola</li>
    <li class="breadcrumb-item"><a href="{{ route('admission.admin.database.manage.registrants.index') }}">Calon mahasiswa baru</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admission.admin.database.manage.registrants.show', ['registrant' => $registrant->id]) }}">{{ $registrant->kd }}</a></li>
    <li class="breadcrumb-item active">Riwayat pendidikan</li>
@endsection

@section('content')
    <h2 class="mb-0"><a class="text-decoration-none small" href="{{ request('next', url()->previous()) }}"><i class="mdi mdi-arrow-left-circle"></i></a> Riwayat pendidikan</h2>
    <hr>
    <div class="row">
        <div class="col-md-8">
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
                                    <form class="form-block" action="{{ route('admission.admin.database.manage.registrants.update', ['registrant' => $registrant->id, 'key' => 'studies.delete', 'study_id' => $study->id, 'next' => url()->full()]) }}" method="POST"> @csrf @method('PUT')
                                        <a href="{{ route('admission.admin.database.manage.registrants.edit', ['registrant' => $registrant->id, 'study_id' => $study->id, 'key' => 'studies.edit', 'uid' => $registrant->user_id, 'next' => url()->full()]) }}">Edit</a> &bull;
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
                    <a href="{{ route('admission.admin.database.manage.registrants.edit', ['registrant' => $registrant->id, 'key' => 'studies.create', 'uid' => $registrant->user_id, 'next' => url()->full()]) }}" class="btn btn-success">Tambah riwayat pendidikan</a>
                    <a class="btn btn-secondary" href="{{ route('admission.admin.database.manage.registrants.show', ['registrant' => $registrant->id]) }}">Kembali</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            @include('admission::includes.registrant-information', ['registrant' => $registrant])
        </div>
    </div>
@endsection