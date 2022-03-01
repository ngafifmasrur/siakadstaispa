@extends('layouts.pdf')

@section('title', 'LAPORAN-PEMBAYARAN-'.$range)

@php
    $values['cash'] = $payments->where('cash', 1)->pluck('value');
    $values['noncash'] = $payments->where('cash', 0)->pluck('value');
@endphp

@section('content')
@foreach($admission->payments as $payment)
    @php
        $subtotal = [];
    @endphp
    <main>
        <h4 class="center"><u>LAPORAN KEUANGAN</u></h4>
        <h5 class="center">JENIS PEMBAYARAN : <span style="color: #f00">{{ $payment->name }}</span></h5>
        <br>
        <table>
            <tr>
                <td width="120">Laporan tanggal</td>
                <td width="5">:</td>
                <td>{{ strftime('%d %B %Y', strtotime($date['from'])) }} - {{ strftime('%d %B %Y', strtotime($date['to'])) }}</td>
            </tr>
            <tr>
                <td width="120">Jumlah transaksi</td>
                <td width="5">:</td>
                <td>{{ count($payments->where('registrant.payment_id', $payment->id)) }}</td>
            </tr>
        </table>
        <br>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th style="line-height: 7pt;" rowspan="2">No</th>
                    <th style="line-height: 7pt;" rowspan="2">Nama pembayaran</th>
                    <th style="line-height: 7pt;" class="center" colspan="2">Tunai</th>
                    <th style="line-height: 7pt;" class="center" colspan="2">Non-tunai</th>
                    <th style="line-height: 7pt;" class="center" rowspan="2">Total</th>
                </tr>
                <tr>
                    <th style="line-height: 7pt;" class="center">Transaksi</th>
                    <th style="line-height: 7pt;" class="center">Nominal</th>
                    <th style="line-height: 7pt;" class="center">Transaksi</th>
                    <th style="line-height: 7pt;" class="center">Nominal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($payment->items->groupBy(function ($value) { return $value->category->name ?? 'Lainnya'; }) as $category => $itemable)
                    <tr>
                        <td style="line-height: 7pt; background-color: #ccc;" colspan="7">{{ $category }}</td>
                    </tr>
                    @foreach($itemable as $item)
                        @php
                            $total = [];
                            foreach ($values as $type => $valueable) {
                                foreach ($valueable as $value) {
                                    if(isset($value[$item->id])) {
                                        $total[$type][] = $value[$item->id];
                                        $subtotal[$type][] = $value[$item->id];
                                    }
                                }
                            }
                        @endphp
                        <tr>
                            <td style="line-height: 7pt;"><small>{{ $loop->iteration }}</small></td>
                            <td style="line-height: 7pt;"><small>{{ $item->name }}</small></td>
                            <td class="center" style="line-height: 7pt;"><small>{{ count($total['cash'] ?? []) }}</span></small></td>
                            <td style="line-height: 12pt; text-align: right; font-family: monospace;"><strong><small>{{ number_format(array_sum($total['cash'] ?? [0]), 0, ',', '.') }}</span></small></strong></td>
                            <td class="center" style="line-height: 7pt;"><small>{{ count($total['noncash'] ?? []) }}</span></small></td>
                            <td style="line-height: 12pt; text-align: right; font-family: monospace;"><strong><small>{{ number_format(array_sum($total['noncash'] ?? [0]), 0, ',', '.') }}</span></small></strong></td>
                            <td style="line-height: 12pt; text-align: right; font-family: monospace;"><strong><small>{{ number_format((array_sum($total['cash'] ?? [0]) + array_sum($total['noncash'] ?? [0])), 0, ',', '.') }}</span></small></strong></td>
                        </tr>
                    @endforeach
                @endforeach
                <tr>
                    <th style="line-height: 7pt;" colspan="2">JUMLAH</th>
                    <td class="center" style="line-height: 7pt;"><small>{{ count($subtotal['cash'] ?? []) }}</span></small></td>
                    <td style="line-height: 12pt; text-align: right; font-family: monospace;"><strong><small>{{ number_format(array_sum($subtotal['cash'] ?? [0]), 0, ',', '.') }}</span></small></strong></td>
                    <td class="center" style="line-height: 7pt;"><small>{{ count($subtotal['noncash'] ?? []) }}</span></small></td>
                    <td style="line-height: 12pt; text-align: right; font-family: monospace;"><strong><small>{{ number_format(array_sum($subtotal['noncash'] ?? [0]), 0, ',', '.') }}</span></small></strong></td>
                    <td style="line-height: 12pt; text-align: right; font-family: monospace;"><strong><small>{{ number_format((array_sum($subtotal['cash'] ?? [0]) + array_sum($subtotal['noncash'] ?? [0])), 0, ',', '.') }}</span></small></strong></td>
                </tr>
            </tbody>
        </table>
    </main>
    @if(!$loop->last)
        <div class="page-break"></div>
    @endif
@endforeach
<div class="page-break"></div>
@foreach($payments->groupBy(function($value) { return config('admission.sex-transform')[$value->registrant->user->profile->sex] ?? 'LAINNYA'; }) as $sex => $paymentable)
    @php
        $subtotal = 0;
    @endphp
    <main>
        <h4 class="center"><u>LAPORAN KEUANGAN PER KWITANSI</u></h4>
        <h5 class="center"><span style="color: #f00">{{ strtoupper($sex) }}</span></h5>
        <br>
        <table>
            <tr>
                <td width="120">Laporan tanggal</td>
                <td width="5">:</td>
                <td>{{ strftime('%d %B %Y', strtotime($date['from'])) }} - {{ strftime('%d %B %Y', strtotime($date['to'])) }}</td>
            </tr>
            <tr>
                <td width="120">Jumlah transaksi</td>
                <td width="5">:</td>
                <td>{{ count($paymentable) }}</td>
            </tr>
        </table>
        <br>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th style="line-height: 7pt;">No</th>
                    <th style="line-height: 7pt;">Jenis</th>
                    <th style="line-height: 7pt;">No kwitansi</th>
                    <th style="line-height: 7pt;">Nama</th>
                    <th style="line-height: 7pt;">Tgl transaksi</th>
                    <th style="line-height: 7pt;">Nominal</th>
                    <th style="line-height: 7pt;">Metode</th>
                </tr>
            </thead>
            <tbody>
                @foreach($paymentable as $payment)
                    @php
                        $subtotal += $payment->value->sum();
                    @endphp
                    <tr>
                        <td style="background-color: #fff; line-height: 7pt; font-size: 7pt;">{{ $loop->iteration }}</td>
                        <td style="background-color: #fff; line-height: 7pt; font-size: 7pt;">{{ $payment->registrant->payment->name }}</td>
                        <td style="background-color: #fff; line-height: 7pt; font-size: 7pt;">{{ substr($payment->kd, 0, 17) }}...</td>
                        <td style="background-color: #fff; line-height: 7pt; font-size: 7pt;">{{ $payment->registrant->user->profile->name }}</td>
                        <td style="background-color: #fff; line-height: 7pt; font-size: 7pt;">{{ $payment->created_at->isoFormat('lll') }}</td>
                        <td style="background-color: #fff; line-height: 7pt; font-size: 7pt; text-align: right;">{{ number_format($payment->value->sum(), 0, ',', '.') }}</td>
                        <td style="background-color: #fff; line-height: 7pt; font-size: 7pt; text-align: right;">{{ $payment->cash_name }}</td>
                    </tr>
                @endforeach
                <tr>
                    <th style="line-height: 7pt; font-size: 7pt;" colspan="4">JUMLAH</th>
                    <td style="background-color: #fff; line-height: 7pt; font-size: 7pt; text-align: right;">{{ number_format($subtotal, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>
    </main>
    @if(!$loop->last)
        <div class="page-break"></div>
    @endif
@endforeach
@endsection