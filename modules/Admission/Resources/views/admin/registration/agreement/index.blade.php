@extends('admission::admin.layouts.admin')

@section('subtitle', 'Perjanjian - ')

@section('breadcrumb')
	<li class="breadcrumb-item">Pendaftaran</li>
    <li class="breadcrumb-item active">Perjanjian</li>
@endsection

@section('section')
	<div class="section">
	    <h3 class="mb-1">Perjanjian</h3>
	    <div class="mb-2">Untuk dapat melakukan pembayaran.</div>
	</div>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="mb-0">Data calon mahasiswa</h5>
            <span class="text-muted"> Menampilkan data calon mahasiswa di @if(request('aid') && $admissions->firstWhere('id', request('aid'))) jalur <strong>{{ $admissions->firstWhere('id', request('aid'))->full_name }}</strong> @else semua jalur @endif</span>
        </div>
        <div class="card-body bg-light border-top">
            <form class="form-block" id="search-form" action="{{ route('admission.admin.registration.agreement.index') }}" method="GET">
                <input type="hidden" name="limit" value="{{ request('l', 10) }}">
                <div class="form-inline">
                    <select class="form-control my-1 mr-sm-2" name="aid">
                        <option value="">Semua jalur pendaftaran</option>
                        @foreach(auth()->user()->admissionCommittees->load('admission')->pluck('admission') as $admission)
                            <option value="{{ $admission->id }}" @if(request('aid') == $admission->id) selected @endif> {{ $admission->full_name }} </option>
                        @endforeach
                    </select>
                    <input type="text" class="form-control my-1 mr-sm-2" placeholder="Cari nomor pendaftaran atau nama calon mahasiswa disini ..." name="search" value="{{ request('search', '') }}" required autofocus size="50">
                    <div class="my-1 mr-sm-2">
                        <button type="submit" class="btn btn-success mr-2"><i class="mdi mdi-magnify"></i> Cari</button>
                        <a class="btn btn-secondary" href="{{ route('admission.admin.registration.agreement.index') }}"><i class="mdi mdi-refresh"></i> Refresh</a>
                    </div>
                </div>
            </form>
        </div>
        @if(request('search'))
            <div class="card-body border-top text-muted py-2 alert-info">
                Jika calon mahasiswa yang Anda cari tidak ada, kemungkinan calon mahasiswa tersebut belum divalidasi.
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <tbody>
                        @forelse($registrants as $registrant)
                            <tr class="{{ empty($registrant->special) ?: 'table-warning' }}">
                                <td width="75" nowrap>
                                    <img class="img-fluid rounded" src="{{{ $registrant->avatar ? Storage::url($registrant->avatar) : asset('assets/img/img-blank-3-4.png') }}}" alt="" style="max-height: 100px;">
                                </td>
                                <td nowrap>
                                    <a href="{{ route('admission.admin.database.manage.registrants.show', ['registrant' => $registrant->id]) }}"><strong>{{ $registrant->user->profile->full_name }}</strong></a> <span class="text-muted">{{ $registrant->kd }}</span>@if($registrant->special) <i class="mdi mdi-star"></i> @endif<br>
                                    {{ $registrant->user->profile->sex_name.', '.$registrant->user->profile->pdob}} <br>
                                    @include('admission::includes.registrant-progress-badge', compact('registrant'))
                                </td>
                                <td nowrap>
                                    <strong>Tanggal tes</strong><br>
                                    @if($registrant->test_at)
                                        {{ $registrant->test_at->formatLocalized('%A, %d %B %Y') }} <br>
                                        {{ $registrant->session->name.' ('.$registrant->session->range.')' }}
                                    @else
                                        <span class="text-muted">(Belum diisi)</span>
                                    @endif
                                </td>
                                @can('giveAgreementRegistrant', AdmissionRegistrant::class)
                                    <td class="py-2 align-middle border-left text-center" nowrap>
                                        <a class="btn btn-success btn-sm" href="{{ route('admission.admin.registration.agreement.print', ['registrant' => $registrant->id]) }}" target="_blank"><i class="mdi mdi-printer"></i> Cetak perjanjian</a>
                                        <a class="btn btn-info btn-sm" href="{{ route('admission.admin.registration.agreement.print-alumni', ['registrant' => $registrant->id]) }}" target="_blank"><i class="mdi mdi-printer"></i> Cetak perjanjian alumni</a>
                                    </td>
                                @endcan
                            </tr>
                        @empty
                            <tr>
                                <td class="text-muted px-4">
                                    @if(request('search'))
                                        Pendaftar dengan pencarian "{{ request('search') }}" tidak ditemukan
                                    @else
                                        Silahkan lakukan pencarian terlebih dahulu
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($registrants->count())
                <div class="card-body bg-light border-top">
                    {{ $registrants->appends(request()->all())->links() }}
                </div>
            @endif
        @else
            <div class="card-body text-muted border-top">
                Silahkan lakukan pencarian terlebih dahulu
            </div>
        @endif
    </div>
@endsection