@extends('admission::layouts.default')

@section('subtitle', 'Data prestasi - ')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <h2 class="mb-0"><a class="text-decoration-none small" href="{{ request('next', route('admission.home')) }}"><i class="icon-arrow-left-circle"></i></a> Data prestasi </h2>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <p>Data prestasi digunakan untuk kelengkapan administrasi.</p>
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
                                                <a href="{{ Storage::url($achievement->file) }}" target="_blank"><i class="icon-eye"></i> Lihat</a>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td nowrap class="align-middle py-2 border-left">
                                            <form class="form-block" action="{{ route('admission.form.achievements.destroy', ['achievement' => $achievement->id]) }}" method="POST"> @csrf @method('DELETE')
                                                <a href="javascript:;" class="text-danger" onclick="if (confirm('Apakah Anda yakin?')) this.parentNode.submit()"><i class="icon-trash"></i> Hapus</a>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="8" class="text-center"><i>{{ auth()->user()->id == $registrant->user_id ? 'Anda' : $registrant->user->profile->full_name }} belum memiliki prestasi.</i></td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="card-body border-top">
                        <a href="{{ route('admission.form.achievements.create', ['next' => url()->current()]) }}" class="btn btn-success">Tambah data prestasi</a>
                        <a class="btn btn-secondary" href="{{ route('admission.home') }}">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection