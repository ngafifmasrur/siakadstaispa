@extends('admission::admin.layouts.admin')

@section('subtitle', 'Tahap tes - ')

@section('breadcrumb')
	<li class="breadcrumb-item">Pendaftaran</li>
    <li class="breadcrumb-item"><a href="{{ route('admission.admin.registration.test.index') }}">Tahap tes</a></li>
    <li class="breadcrumb-item active">{{ $registrant->kd }}</li>
@endsection

@section('section')
	<div class="section">
	    <h3 class="mb-1">Tahap cbt</h3>
	    <div class="mb-2">Kelola bagian tes pendaftaran.</div>
	</div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-4">
            @include('admission::includes.registrant-information', ['registrant' => $registrant, 'simple' => true])
        </div>
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="mb-0">Penilaian cbt</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-hover mb-0">
                        <thead class="thead-dark">
                            <tr>
                                <th nowrap>Kode Mapel</th>
                                <th nowrap>Nama Mapel</th>
                                <th nowrap>Jumlah Soal</th>
                                <th nowrap>Jawaban Benar</th>
                                <th nowrap>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($admission_cbt as $item)
                                <tr>
                                    <td>{{ $item->kode_mapel }}</td>
                                    <td>{{ $item->mapel }}</td>
                                    <td>{{ $item->jumlah_acakan_soal }}</td>
                                    <td>{{ $item->jumlah_jawaban_benar }}</td>
                                    <td>
                                        @if ($item->status_registrant_cbt == 0)
                                            Belum Dikerjakan
                                        @elseif($item->status_registrant_cbt == 1)
                                            Sedang Dikerjakan
                                        @else
                                            Selesai Dikerjakan
                                        @endif
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection