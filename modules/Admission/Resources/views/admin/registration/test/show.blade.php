@extends('admission::admin.layouts.admin')

@section('subtitle', 'Tahap tes - ')

@section('breadcrumb')
	<li class="breadcrumb-item">Pendaftaran</li>
    <li class="breadcrumb-item"><a href="{{ route('admission.admin.registration.test.index') }}">Tahap tes</a></li>
    <li class="breadcrumb-item active">{{ $registrant->kd }}</li>
@endsection

@section('section')
	<div class="section">
	    <h3 class="mb-1">Tahap tes</h3>
	    <div class="mb-2">Kelola bagian tes pendaftaran.</div>
	</div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-4">
            @include('admission::includes.registrant-information', ['registrant' => $registrant, 'simple' => true])
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="mb-0">Informasi tahap tes</h5>
                </div>
                <div class="card-body border-top">
                    @if($registrant->validated_at)
                        <div>Maaf, Anda tidak dapat mengubah status tahap tes, karena calon mahasiswa telah tervalidasi.</div>
                        @if($registrant->tested_at)
                            <div class="mt-3">
                                <a class="btn btn-success" href="{{ route('admission.admin.registration.test.print', ['registrant' => $registrant->id]) }}" target="_blank"><i class="mdi mdi-printer"></i> Cetak surat kelulusan</a>
                            </div>
                        @endif
                    @else
                        <form class="form-block" action="{{ route('admission.admin.registration.test.pass', ['registrant' => $registrant->id]) }}" method="POST"> @csrf @method('PUT')
                            <div class="form-group">
                                <label class="form-control-label">Status tahap tes</label>
                                <select class="form-control{{ $errors->has('pass') ? ' is-invalid' : '' }}" name="pass">
                                    <option value="0" @if($registrant->tested_at) selected @endif>Belum lulus</option>
                                    <option value="1" @if($registrant->tested_at) selected @endif>Sudah lulus</option>
                                </select>
                                @if ($errors->has('pass'))
                                    <span class="invalid-feedback"> {{ $errors->first('pass') }} </span>
                                @endif
                            </div>
                            <div class="form-group mb-0">
                                <button type="submit" class="btn btn-success"><i class="mdi mdi-check"></i> Simpan</button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-8">
            @if($registrant->tested_at)
                <a class="btn btn-success" href="{{ route('admission.admin.registration.test.print', ['registrant' => $registrant->id]) }}" target="_blank"><i class="mdi mdi-printer"></i> Cetak surat kelulusan</a>
            @endif
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="mb-0">Penilaian tes</h5>
                </div>
                <form class="form-block" action="{{ ($registrant->tested_at) ? 'javascript:;   ' : route('admission.admin.registration.test.update', ['registrant' => $registrant->id]) }}" method="POST"> @csrf @method('PUT')
                    <div class="table-responsive">
                        <table class="table table-striped table-hover mb-0">
                            <thead class="thead-dark">
                                <tr>
                                    <th nowrap>Tahap tes</th>
                                    <th nowrap>Nilai</th>
                                    <th nowrap>Catatan</th>
                                    <th nowrap>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $sum = 0;
                                @endphp
                                @forelse($registrant->tests as $test)
                                    <tr>
                                        <td class="align-middle">
                                            <strong>{{ $test->name }}</strong> <br>
                                            KKM : {{ $test->minimal }}
                                        </td>
                                        <td class="align-middle">
                                            <div class="form-group mb-0">
                                                <input type="number" name="test[{{ $test->id }}][value]" class="form-control{{ $errors->has('test.'.$test->id.'.value') ? ' is-invalid' : '' }}" value="{{ $test->pivot->value ?? 0 }}" @if($registrant->tested_at) disabled readonly @endif>
                                                @if ($errors->has('test.'.$test->id.'.value')) <span class="invalid-feedback"> <strong>{{ $errors->first('test.'.$test->id.'.value') }}</strong> </span> @endif
                                            </div>
                                        </td>
                                        <td class="align-middle">
                                            <div class="form-group mb-0">
                                                <input type="text" name="test[{{ $test->id }}][description]" class="form-control{{ $errors->has('test.'.$test->id.'.description') ? ' is-invalid' : '' }}" value="{{ $test->pivot->description }}" @if($registrant->tested_at) disabled readonly @endif>
                                                @if ($errors->has('test.'.$test->id.'.description')) <span class="invalid-feedback"> <strong>{{ $errors->first('test.'.$test->id.'.description') }}</strong> </span> @endif
                                                @php
                                                    $sum += $test->pivot->value;
                                                @endphp
                                            </div>
                                        </td>
                                        <td class="align-middle text-center">
                                            @if ($test->pivot->value == 0 || is_null($test->pivot->value))
                                                <span class="badge badge-warning">Belum dinilai</span>
                                            @elseif($test->pivot->value >= $test->minimal)
                                                <span class="badge badge-success">Tuntas</span>
                                            @else
                                                <span class="badge badge-danger">Belum tuntas</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @if($loop->last)
                                        <tr>
                                            <td class="py-1 bg-dark align-middle"><strong>JUMLAH</strong></td>
                                            <td class="py-1 pl-4 text-left align-middle" colspan="3"><strong>{{ $sum }}</strong></td>
                                        <tr>
                                        </tr>
                                            <td class="py-1 bg-dark align-middle"><strong>RATA-RATA</strong></td>
                                            <td class="py-1 pl-4 text-left align-middle" colspan="3"><strong>{{ round($registrant->tests()->average('value'), 2) }}</strong></td>
                                        </tr>
                                    @endif
                                @empty
                                    <tr>
                                        <td colspan="4">Tidak ada tes yang ditetapkan pada calon mahasiswa ini</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if(count($registrant->tests))
                        <div class="card-body">
                            @if($registrant->tested_at)
                                <a href="javascript:;" class="btn btn-secondary disabled"><i class="mdi mdi-check"></i> Simpan</a>
                            @else
                                <a href="{{ route('admission.admin.registration.test.print-questions', ['registrant' => $registrant->id]) }}" class="btn btn-info" target="_blank"><i class="mdi mdi-printer"></i> Cetak soal tes tulis</a>
                                <button type="submit" class="btn btn-success"><i class="mdi mdi-check"></i> Simpan</button>
                            @endif
                            <a class="btn btn-success" href="{{ route('admission.admin.registration.test.print', ['registrant' => $registrant->id]) }}" target="_blank"><i class="mdi mdi-printer"></i> Cetak surat kelulusan</a>
                            <a class="btn btn-secondary" href="{{ route('admission.admin.registration.test.index') }}"><i class="mdi mdi-arrow-left-circle"></i> Kembali</a>
                        </div>
                    @endif
                </form>
                @if(!$registrant->tested_at)
                    @if(count($registrant->tests) == 0)
                        <div class="card-body border-top">
                            @if(count($tests))
                                <form class="form-block form-confirm" action="{{ route('admission.admin.registration.test.assign', ['registrant' => $registrant->id]) }}" method="POST"> @csrf @method('PUT')
                                    <div class="form-group">
                                        <label class="form-control-label">Tetapkan tes untuk calon mahasiswa.</label>
                                        @foreach($tests as $test)
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"  id="tests[{{ $test->id }}]" name="tests[]" value="{{ $test->id }}" checked>
                                                <label class="form-check-label" for="tests[{{ $test->id }}]" >{{ $test->name }}</label>
                                            </div>
                                        @endforeach
                                        @if ($errors->has('tests')) <small><span class="text-danger"> <strong>{{ $errors->first('tests') }}</strong> </span></small> @endif
                                    </div>
                                    <p class="text-danger">Anda hanya dapat menentukan jenis tes calon mahasiswa satu kali</p>
                                    <div class="form-group mb-0">
                                        <button type="submit" class="btn btn-success"><i class="mdi mdi-check"></i> Tetapkan</button>
                                        <a class="btn btn-secondary" href="{{ url()->previous() }}"><i class="mdi mdi-arrow-left-circle"></i> Kembali</a>
                                    </div>
                                </form>
                            @else
                                <span>Tidak dapat menetapkan tes untuk calon mahasiswa, silahkan hubungi Administrator Pusat.</span>
                            @endif
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
@endsection