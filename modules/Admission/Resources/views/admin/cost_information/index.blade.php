@extends('admission::admin.layouts.admin')

@section('subtitle', 'Informasi Biaya - ')

@section('breadcrumb')
    <li class="breadcrumb-item">Informasi Biaya</li>
    <li class="breadcrumb-item active">Data Informasi Biaya</li>
@endsection

@section('section')
    <div class="section">
        <h3 class="mb-1">Kelola data Informasi Biaya</h3>
        <div class="mb-2">Tambah dan ubah Informasi Biaya.</div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="mb-0">Informasi Biaya</h5>
                    <span class="text-muted">Menampilkan data Informasi Biaya</span>
                    <br>
                </div>
                <div class="card-body bg-light border-top">
                    <form id="constInformations"
                        action="{{ route('admission.admin.cost_information.storeOrUpdateCosts') }}" method="POST">
                        @csrf

                        @foreach ($costInfomations as $costInfomation)
                            <div class="form-group">
                                <label for="{{ $costInfomation['key'] }}">{{ $costInfomation['name'] }}</label>
                                <textarea class="form-control summernote"
                                    name="{{ $costInfomation['key'] }}" id="{{ $costInfomation['key'] }}"
                                    cols="5" rows="5">{{ $costInfomation['value'] }}</textarea>
                            </div>
                        @endforeach

                        <div class="text-right">
                            <button type="button" class="btn btn-primary mb-3"
                                onclick="document.getElementById('constInformations').submit();">
                                Simpan
                            </button>
                        </div>
                    </form>

                    <hr>

                    <form class="form-block" id="search-form"
                        action="{{ route('admission.admin.cost_information.index') }}"
                        method="GET">
                        <input type="hidden" name="limit" value="{{ request('l', 10) }}">
                        <div class="form-inline d-flex justify-content-between">
                            <h6>Biaya Pesantren</h6>
                            <div class="my-1 mr-sm-2">
                                <a class="btn btn-primary"
                                    href="{{ route('admission.admin.cost_information.create', request()->all()) }}">
                                    <i class="mdi mdi-plus"></i> Tambah Biaya Pesantren
                                </a>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover mb-0" aria-describedby="Cost Informations">
                        <thead class="thead-dark">
                            <tr>
                                <th>Nama Biaya</th>
                                <th>Detail</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data as $item)
                                <tr>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ numToRupiah($item->detail) }}</td>
                                    <td class="py-2 align-middle border-left text-center" nowrap>
                                        <a class="btn btn-warning btn-sm"
                                            href="{{ route('admission.admin.cost_information.edit', [
                                                'costInformation' => $item->id,
                                            ]) }}">
                                            <i class="mdi mdi-pencil"></i>
                                        </a>
                                        <form class="form-block form-confirm d-inline"
                                            action="{{ route('admission.admin.cost_information.destroy', [
                                                'costInformation' => $item->id,
                                            ]) }}"
                                            method="POST">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-danger btn-sm">
                                                <i class="mdi mdi-trash-can"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-muted px-4">
                                        Tidak ada data Informasi Biaya
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card">
                <div class="card-body bg-light border-top">
                    <form id="monthlyCost"
                        action="{{ route('admission.admin.cost_information.storeMonthlyCosts') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="biaya_bulanan_pesantren">Biaya Bulanan Pesantren</label>
                            <input class="form-control" type="text" name="biaya_bulanan_pesantren"
                                value="{{ old('biaya_bulanan_pesantren', $monthlyCost->detail ?? 0)}}">
                        </div>

                        <div class="text-right">
                            <button type="button" class="btn btn-primary mb-3"
                                onclick="document.getElementById('monthlyCost').submit();">
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('style')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
@endpush

@push('script')
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script>
    $('.summernote').summernote({
      tabsize: 2,
      height: 100
    });
  </script>
@endpush
