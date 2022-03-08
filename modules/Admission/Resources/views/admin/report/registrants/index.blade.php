@extends('admission::admin.layouts.admin')

@section('subtitle', 'Laporan pendaftaran - ')

@section('breadcrumb')
	<li class="breadcrumb-item">Laporan</li>
    <li class="breadcrumb-item active">Pendaftaran</li>
@endsection

@section('section')
	<div class="section">
	    <h3 class="mb-1">Pendaftaran</h3>
	    <div class="mb-2">Laporan pendaftaran calon mahasiswa.</div>
	</div>
@endsection

@php
	$admission = $admissions->firstWhere('id', request('aid'))
@endphp

@push('script')
    <script src="{{ asset('assets/js/tableToXls.js') }}"></script>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-4">
        	<div class="card">
    			<div class="card-body">
    			    <h5 class="mb-0">Pencarian</h5>
    			</div>
    			<div class="card-body border-top">
    			    <form class="form-block" id="search-form" action="{{ route('admission.admin.report.registrants.index') }}" method="GET">
    			        <div class="form-group">
    			            <label>Jalur pendaftaran</label>
    			            <select class="form-control" name="aid" required>
    			                <option value="">-- Pilih jalur pendaftaran --</option>
    			                @foreach($admissions as $value)
    			                    <option value="{{ $value->id }}" @if(request('aid') == $value->id) selected @endif> {{ $value->full_name }} </option>
    			                @endforeach
    			            </select>
    			        </div>
    			        <div class="form-group mb-0">   
    			            <button type="submit" class="btn btn-success mr-2"><i class="mdi mdi-magnify"></i> Cari</button>
    			        </div>
    			    </form>
    			</div>
        	</div>
        </div>
        <div class="col-md-8">
        	<div class="card">
        		<div class="card-body">
                    <h5 class="mb-0">Laporan</h5>
                </div>
                @if($admission)
                    <div id="accordion" role="tablist">
                        <div class="card-header bg-dark rounded-0" role="tab" data-toggle="collapse" data-target="#export-registrants-tab" style="cursor: pointer;">
                            <i class="icon-plus"></i> Laporan pendaftaran calon mahasiswa baru
                        </div>
                        <div class="collapse show" id="export-registrants-tab" role="tabpanel" data-parent="#accordion">
                            <div class="card-body">
                                @include('admission::admin.report.registrants.form.registrants')
                            </div>
                        </div>
                    </div>
                @else
                    <div class="card-footer">
                        <i>Silahkan tentukan terlebih dahulu jalur pendaftaran</i>
                    </div>
                @endif
        	</div>
        </div>
    </div>
@endsection