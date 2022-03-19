@extends('admission::admin.layouts.admin')

@section('subtitle', 'Import Soal - ')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admission.admin.cbt.index') }}">CBT</a></li>
    <li class="breadcrumb-item active">Import Soal</li>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2 class="mb-0"><a class="text-decoration-none small" href="{{ request('next', url()->previous()) }}"><i class="mdi mdi-arrow-left-circle"></i></a> Import Soal Mapel</h2>
            <hr>
            <div class="card">
                <div class="card-body">
                    <form class="form-block" action="{{ route('admission.admin.cbt.import_store', ['cbt' => $cbt->id, 'next' => request('next', url()->previous()) ]) }}" method="POST" enctype="multipart/form-data"> @csrf
                        <fieldset>
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">Kode Mapel</label>
                                <div class="col-md-7">
                                    <input class="form-control" type="text" name="kode_mapel" id="kode_mapel" value="{{ $cbt->kode_mapel }}" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">Nama Mapel</label>
                                <div class="col-md-7">
                                    <input class="form-control" type="text" name="mapel" id="mapel" value="{{ $cbt->mapel }}" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">Import File</label>
                                <div class="col-md-7">
                                    <input class="form-control-file" type="file" name="file" id="file">
                                </div>
                            </div>
                        </fieldset>
                        <hr>
                        <div class="form-group row mb-0">
                            <div class="col-md-7 offset-md-4">
                                <button class="btn btn-success" type="submit">Import</button>
                                <a class="btn btn-secondary" href="{{ request('next', url()->previous()) }}">Kembali</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body p-3">
                    <h5 class="mb-0 py-1"> Daftar Soal</h5>
                </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover mb-0">
                            <thead class="thead-dark">
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Soal</th>
                                    <th class="text-center">A</th>
                                    <th class="text-center">B</th>
                                    <th class="text-center">C</th>
                                    <th class="text-center">D</th>
                                    <th class="text-center">E</th>
                                    <th class="text-center">Jawaban</th>
                                    <th class="text-center">Skor</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($cbt->questions as $item)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $item->soal }}</td>
                                        <td>{{ $item->jawaban_a ?? '-' }}</td>
                                        <td>{{ $item->jawaban_b ?? '-' }}</td>
                                        <td>{{ $item->jawaban_c ?? '-' }}</td>
                                        <td>{{ $item->jawaban_d ?? '-' }}</td>
                                        <td>{{ $item->jawaban_e ?? '-' }}</td>
                                        <td class="text-center">{{ $item->jawaban_benar ?? '-' }}</td>
                                        <td class="text-center">{{ $item->skor ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-muted px-4">
                                            Tidak ada data soal
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
            </div>
        </div>
    </div>
@endsection