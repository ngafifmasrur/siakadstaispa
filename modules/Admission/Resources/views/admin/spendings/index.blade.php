@extends('admission::admin.layouts.admin')

@section('subtitle', 'Pengeluaran - ')

@section('breadcrumb')
    <li class="breadcrumb-item">Admin</li>
    <li class="breadcrumb-item">Pengeluaran</li>
    <li class="breadcrumb-item active">Data</li>
@endsection

@section('section')
    <div class="section">
        <h3 class="mb-1">Pengeluaran</h3>
        <div class="mb-2">Data pengeluaran selama pendaftaran dari bendahara.</div>
    </div>
@endsection

@php
    $sum = 0;
@endphp

@section('content')
<div class="card mb-4">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6"><h5 class="mb-3 mb-md-0 d-inline">Data pengeluaran</h5></div>
            <div class="col-md-6 text-md-right">
                <div class="mt-3 mt-md-0">
                    <a class="btn btn-success btn-sm" href="{{ route('admission.admin.spendings.report') }}" target="_blank"><i class="mdi mdi-download"></i> Unduh laporan</a>
                    <a class="btn btn-success btn-sm" href="{{ route('admission.admin.spendings.create') }}"><i class="mdi mdi-plus-circle-outline"></i> Tambah</a>
                </div>
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-striped mb-0">
            <thead class="thead-dark">
                <tr>
                    <th>No</th>
                    <th>Item</th>
                    <th>Harga @ satuan</th>
                    <th>Toko</th>
                    <th>Tgl beli</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($spendings as $spending)
                    @php
                        $times = $spending->amount * ($spending->qty ?: 1);
                        $sum += $times ?: 0;
                    @endphp
                    <tr>
                        <td nowrap>{{ $loop->iteration }}</td>
                        <td nowrap><strong>{{ $spending->item }}</strong> <br> {{ $spending->committee->name }}</td>
                        <td nowrap>{{ $spending->qty }} &times; {{ number_format($spending->amount, 0, ',', '.') }} @ {{ $spending->unit_name }} <br> <strong>{{ number_format($times, 0, ',', '.') }}</strong></td>
                        <td nowrap>{{ $spending->shop }} <br> <small>Dibeli oleh {{ $spending->buyer }}</small></td>
                        <td nowrap>{{ $spending->payed_at }}</td>
                        <td nowrap class="py-2">
                            <form class="form-block form-confirm" action="{{ route('admission.admin.spendings.destroy', ['spending' => $spending->id]) }}" method="POST"> @csrf @method('delete')
                                @if($spending->receipt)
                                    <a class="btn btn-info btn-sm" href="{{ Storage::url($spending->receipt) }}"><i class="mdi mdi-eye"></i></a>
                                @else
                                    <a class="btn btn-warning btn-sm" href="{{ route('admission.admin.spendings.edit', ['spending' => $spending->id]) }}"><i class="mdi mdi-pencil"></i></a>
                                    <button type="button" class="btn btn-secondary btn-sm" disabled><i class="mdi mdi-eye"></i></button>
                                @endif
                                <button class="btn btn-danger btn-sm"><i class="mdi mdi-trash-can"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8">Tidak ada item pengeluaran</td>
                    </tr>
                @endforelse
                <tr>
                    <th colspan="2">Jumlah</th>
                    <td><strong>{{ number_format($sum, 0, ',', '.') }}</strong></td>
                    <td colspan="3"></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@stop