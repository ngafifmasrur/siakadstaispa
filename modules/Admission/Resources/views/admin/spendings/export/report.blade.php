@extends('layouts.pdf')

@section('title', 'LAPORAN-PENGELUARAN')

@php
	$sum = 0;
@endphp

@section('content')
<style>
	tr td {
		font-size: 9pt !important;
		line-height: 8pt !important;
		background-color: #fff;
	}
</style>
<main>
	<h4 class="center"><u>LAPORAN PENGELUARAN</u></h4>
	<br>
	<table class="table table-bordered">
		<thead>
			<tr>
				<th>No</th>
				<th>Item</th>
				<th>Qty</th>
				<th>Harga satuan</th>
				<th>Jumlah</th>
				<th>Toko</th>
				<th>Divisi</th>
				<th>Pembeli</th>
				<th>Tgl Beli</th>
			</tr>
		</thead>
		<tbody>
			@foreach($spendings as $spending)
				@php
					$total = ($spending->qty ?? 1) * $spending->amount ?? 0;
					$sum += $total;
				@endphp
				<tr>
					<td nowrap>{{ $loop->iteration }}</td>
					<td nowrap>{{ $spending->item }}</td>
					<td nowrap>{{ $spending->qty }} {{ $spending->unit_name }}</td>
					<td nowrap style="text-align: right;">{{ number_format($spending->amount, 0, ',', '.') }}</td>
					<td nowrap style="text-align: right;">{{ number_format($total, 0, ',', '.') }}</td>
					<td>{{ $spending->shop }}</td>
					<td>{{ $spending->committee->name }}</td>
					<td nowrap>{{ $spending->buyer }}</td>
					<td nowrap>{{ $spending->payed_at }}</td>
				</tr>
			@endforeach
			<tr>
				<td nowrap colspan="4"><strong>JUMLAH</strong></td>
				<td nowrap style="text-align: right;"><strong>{{ number_format($total, 0, ',', '.') }}</strong></td>
				<td colspan="4"></td>
			</tr>
		</tbody>
	</table>
</main>
@endsection