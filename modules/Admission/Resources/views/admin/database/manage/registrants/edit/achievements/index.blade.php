@extends('admission::admin.layouts.admin')

@section('subtitle', 'Kelola calon mahasiswa baru - ')

@section('breadcrumb')
	<li class="breadcrumb-item">Pangkalan data</li>
	<li class="breadcrumb-item">Kelola</li>
    <li class="breadcrumb-item"><a href="{{ route('admission.admin.database.manage.registrants.index') }}">Calon mahasiswa baru</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admission.admin.database.manage.registrants.show', ['registrant' => $registrant->id]) }}">{{ $registrant->kd }}</a></li>
    <li class="breadcrumb-item active">Data prestasi</li>
@endsection

@section('content')
    <h2 class="mb-0"><a class="text-decoration-none small" href="{{ request('next', url()->previous()) }}"><i class="mdi mdi-arrow-left-circle"></i></a> Data prestasi</h2>
    <hr>
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h4 class="mb-0">Data prestasi</h4>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped border-bottom mb-0">
                        <thead>
                            <tr class="bg-dark text-white">
                                <th width="1">No.</th>
                                <th>Nama</th>
                                <th>Jenis</th>
                                <th>Tahun</th>
                                <th>Peringkat</th>
                                <th>Tingkat</th>
                                <th>Berkas</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($achievements as $i => $achievement)
                                <tr>
                                    <td nowrap> {{ $loop->iteration }} </td>
                                    <td nowrap> {{ $achievement->name }} </td>
                                    <td nowrap> {{ $achievement->type->name}} </td>
                                    <td nowrap> {{ $achievement->year }}</td>
                                    <td nowrap> {{ $achievement->num->name}} </td>
                                    <td nowrap> {{ $achievement->territory->name}} </td>
                                    <td nowrap class="align-middle py-2">
                                        @if ($achievement->file)
                                            <a href="{{ Storage::url($achievement->file) }}" target="_blank"><i class="mdi mdi-eye"></i> Lihat</a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td nowrap class="align-middle py-2 border-left">
                                        <form class="form-block" action="{{ route('admission.admin.database.manage.registrants.update', ['registrant' => $registrant->id, 'key' => 'achievements.delete', 'achievement_id' => $achievement->id, 'next' => url()->full()]) }}" method="POST"> @csrf @method('PUT')
                                            <a href="javascript:;" class="text-danger" onclick="if (confirm('Apakah Anda yakin?')) this.parentNode.submit()"><i class="mdi mdi-trash"></i> Hapus</a>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="8" class="text-center"><i>{{ auth()->user()->id == $registrant->user_id ? 'Anda' : $registrant->user->profile->full_name }} belum memiliki prestasi.</i></td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-body">
                    <a href="{{ route('admission.admin.database.manage.registrants.edit', ['registrant' => $registrant->id, 'key' => 'achievements.create', 'uid' => $registrant->user_id, 'next' => url()->full()]) }}" class="btn btn-success">Tambah data prestasi</a>
                    <a class="btn btn-secondary" href="{{ route('admission.admin.database.manage.registrants.show', ['registrant' => $registrant->id]) }}">Kembali</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            @include('admission::includes.registrant-information', ['registrant' => $registrant])
        </div>
    </div>
@endsection