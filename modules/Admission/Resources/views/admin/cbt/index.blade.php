@extends('admission::admin.layouts.admin')

@section('subtitle', 'CBT - ')

@section('breadcrumb')
    <li class="breadcrumb-item">CBT</li>
    <li class="breadcrumb-item active">Data Mata Pelajaran CBT</li>
@endsection

@section('section')
    <div class="section">
        <h3 class="mb-1">Kelola data Mata Pelajaran CBT</h3>
        <div class="mb-2">Tambah dan ubah mata pelajaran untuk CBT.</div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="mb-0">Data mata pelajaran</h5>
                    <span class="text-muted"> Menampilkan data mata pelajaran di @if(request('aid') && $admissions->firstWhere('id', request('aid'))) jalur <strong>{{ $admissions->firstWhere('id', request('aid'))->full_name }}</strong> @else semua jalur @endif</span>
                    <br>
                </div>
                <div class="card-body bg-light border-top">
                    <form class="form-block" id="search-form" action="{{ route('admission.admin.cbt.index') }}" method="GET">
                        <input type="hidden" name="limit" value="{{ request('l', 10) }}">
                        <div class="form-inline">
                            <select class="form-control my-1 mr-sm-2" name="aid">
                                <option value="">Semua jalur pendaftaran</option>
                                @foreach(auth()->user()->admissionCommittees->load('admission')->pluck('admission') as $admission)
                                    <option value="{{ $admission->id }}" @if(request('aid') == $admission->id) selected @endif> {{ $admission->full_name }} </option>
                                @endforeach
                            </select>
                            <div class="my-1 mr-sm-2">
                                <button type="submit" class="btn btn-success mr-2"><i class="mdi mdi-magnify"></i> Cari</button>
                                <a class="btn btn-primary" href="{{ route('admission.admin.cbt.create', request()->all()) }}"><i class="mdi mdi-add"></i> Tambah mapel</a>
                                <a class="btn btn-secondary" href="{{ route('admission.admin.cbt.index') }}"><i class="mdi mdi-refresh"></i> Refresh</a>

                            </div>
                        </div>
                    </form>
                </div>

                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="thead-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Periode</th>
                                    <th>Kode</th>
                                    <th>Nama</th>
                                    <th>Total Soal</th>
                                    <th>Deskripsi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($data as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->admission->full_name }}</td>
                                        <td>{{ $item->kode_mapel }}</td>
                                        <td>{{ $item->mapel }}</td>
                                        <td>{{ $item->questions->count() }}</td>
                                        <td>{{ $item->description ?? '-' }}</td>
                                        <td class="py-2 align-middle border-left text-center" nowrap>
                                            <a class="btn btn-success btn-sm" href="{{ route('admission.admin.cbt.import', ['cbt' => $item->id]) }}"><i class="mdi mdi-upload"></i></a>
                                            <a class="btn btn-warning btn-sm" href="{{ route('admission.admin.cbt.edit', ['cbt' => $item->id]) }}"><i class="mdi mdi-pencil"></i></a>
                                            <form class="form-block form-confirm d-inline" action="{{ route('admission.admin.cbt.destroy', ['cbt' => $item->id]) }}" method="POST"> @csrf @method('DELETE')
                                                <button class="btn btn-danger btn-sm"><i class="mdi mdi-trash-can"></i></button>
                                            </form>

                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-muted px-4">
                                            Tidak ada data mapel
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
            </div>
        </div>
    </div>


</div>
@endsection