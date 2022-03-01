@extends('layouts.pdf')

@section('title', 'KWITANSI-PEMBAYARAN-'.$registrant->kd)

@section('kop', strtoupper(config('admission.long_name')).' '.$registrant->admission->period->name)
@section('kop-sub', strtoupper($registrant->admission->period->instance->long_name))

@php
    $sum = round($registrant->tests()->sum('value'), 2);
    $average = round($registrant->tests()->average('value'), 2);
    $detail = [
        'Nama lengkap' => $user->profile->name,
        'Pilihan prodi' => ($registrant->major1_name ?? '-').'/'.($registrant->major2_name ?? '-'),
        'Jenis pembayaran' => $registrant->payment->name,
        'Waktu transaksi' => $transaction->payed_at->formatLocalized('%d %B %Y pukul %H:%M WIB'),
        'Metode pembayaran' => $transaction->cash ? 'Tunai' : 'Non-tunai/Transfer (EDC/M-Banking)',
    ];
    $histories = $registrant->transactions->filter(function($trans) use ($transaction) { return $trans->id < $transaction->id; });
@endphp

@section('content')
<main>
    <p class="center"><strong><u>KWITANSI PEMBAYARAN</u></strong></p>
    <p class="center"><small>No Kwitansi: {{ $transaction->kd }}</small></p> <br>
    <table style="margin: 5px 0;">
        @foreach($detail as $k => $v)
            <tr>
                <td width="150">{{ $k }}</td>
                <td width="5">:</td>
                <td><strong>{{ $v }}</strong></td>
            </tr>
        @endforeach
    </table>
    <table class="table" style="line-height: 6pt; font-size: 8.2pt;">
        <thead>
            <tr>
                <th>No</th>
                <th>Item pembayaran</th>
                <th class="center">Sedang dibayar</th>
                <th class="center">Belum dibayar</th>
                <th class="center">Sudah dibayar</th>
                <th class="center">Ket</th>
            </tr>
        </thead>
        <tbody>
            @php
                $sum1 = 0;
                $sum2 = 0;
                $sum3 = 0;
            @endphp
            @foreach ($items->groupBy(function($x) { return $x->category->name; }) as $group => $valuable)
                <tr>
                    <td colspan="6" style="line-height: 6pt; font-size: 8.2pt; background: #eee;">{{ $group }}</td>
                </tr>
                @foreach ($valuable as $item)
                    @php
                        $value = (in_array($item->id, array_keys($payed))) 
                                    ? ($payed[$item->id] ?? $item->amount) 
                                    : ($transaction->value[$item->id] ?? $item->amount);
                    @endphp
                    <tr>
                        <td style="line-height: 6pt; font-size: 8.2pt;">{{ $loop->iteration }}</td>
                        <td style="line-height: 6pt; font-size: 8.2pt;">{{ $item->name }}</td>
                        <td style="vertical-align: middle; font-family: courier; text-align: right; line-height: 6pt; font-size: 8.2pt;">
                            @if(in_array($item->id, array_keys(json_decode($transaction->value, 1))))
                                <strong><span style="float: left;"></span>{{ number_format($value, 0, ',', '.') }}</strong>
                                @php
                                    $sum1 += $value;
                                @endphp
                            @else
                                -
                            @endif
                        </td>
                        <td style="vertical-align: middle; font-family: courier; text-align: right; line-height: 6pt; font-size: 8.2pt;">
                            @if(in_array($item->id, array_diff($items->pluck('id')->toArray(), array_keys($payed), array_keys(json_decode($transaction->value, 1)))))
                                <strong><span style="float: left;"></span>{{ number_format($value, 0, ',', '.') }}</strong>
                                @php
                                    $sum2 += $value;
                                @endphp
                            @else
                                -
                            @endif
                        </td>
                        <td style="vertical-align: middle; font-family: courier; text-align: right; line-height: 6pt; font-size: 8.2pt;">
                            @if(in_array($item->id, array_keys($payed)))
                                <strong><span style="float: left;"></span>{{ number_format($value, 0, ',', '.') }}</strong>
                                @php
                                    $sum3 += $value;
                                @endphp
                            @else
                                -
                            @endif
                        </td>
                        <td style="line-height: 6pt; font-size: 8.2pt;">
                            {{ $item->note }}
                        </td>
                    </tr>
                @endforeach
            @endforeach
            <tr style="background: #eee;">
                <td style="line-height: 6pt; font-size: 8.2pt;" colspan="2">JUMLAH</td>
                <td style="line-height: 6pt; font-size: 8.2pt; vertical-align: middle; font-family: courier; text-align: right;"><strong><span style="float: left;"></span>{{ number_format($sum1, 0, ',', '.') }}</strong></td>
                <td style="line-height: 6pt; font-size: 8.2pt; vertical-align: middle; font-family: courier; text-align: right;"><strong><span style="float: left;"></span>{{ number_format($sum2, 0, ',', '.') }}</strong></td>
                <td style="line-height: 6pt; font-size: 8.2pt; vertical-align: middle; font-family: courier; text-align: right;"><strong><span style="float: left;"></span>{{ number_format($sum3, 0, ',', '.') }}</strong></td>
                <td></td>
            </tr>
        </tbody>
    </table>
    <p style="margin-top: 5px;"><small><strong>Riwayat transaksi</strong></small></p>
    @if(count($histories))
        <table style="border-top: 1px solid #000;">
            <tr>
                <td style="font-size: 8pt;"><i>No.</i></td>
                <td style="font-size: 8pt;"><i>Tgl</i></td>
                <td style="font-size: 8pt;"><i>No.Kwitansi</i></td>
                <td style="font-size: 8pt;"><i>Nominal (Rp)</i></td>
            </tr>
            @foreach($histories as $trans)
            <tr>
                <td style="font-size: 8pt;"><i>{{ $loop->iteration }}</i></td>
                <td style="font-size: 8pt;"><i>{{ $trans->payed_at }}</i></td>
                <td style="font-size: 8pt;"><i>{{ $trans->kd }}</i></td>
                <td style="font-size: 8pt;"><i>{{ number_format($trans->amount, 0, ',', '.') }}</i></td>
            </tr>
            @endforeach
        </table>
    @else
    <p style="color: #777;"><small><i>Tidak ada riwayat</i></small></p>
    @endif
    <table style="position: fixed; bottom:4cm; left: 0;margin-top: 20px; font-size: 10pt;">
        <tr>
            <td width="40%" style="border: 1px solid #111; padding-left: 4px;"><small><cite>Catatan</cite> <br> {{ $transaction->description }}</small></td>
            <td width="2%"></td>
            <td width="58%">
                <table style="font-size: 10pt;">
                    <tr>
                        <td width="48%">
                            <div class="center">
                                <div>&nbsp;</div>
                                Pembayar
                                <div style="height: 60px; border-bottom: 1px solid #000;"></div>
                                {{ $transaction->payer }}
                            </div>
                        </td>
                        <td width="4%"></td>
                        <td width="48%">
                            <div class="center">
                                Sleman, {{ strftime('%d %B %Y', time()) }}
                                <br>
                                Penerima
                                <div style="height: 60px; border-bottom: 1px solid #000;"></div>
                                {{ $transaction->committee->member->profile->name ?: '.......................' }}
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <table style="width: 40%; position: fixed; bottom:1cm; left: 0;">
        <tr>
            <td style="background: #000; color: #fff; vertical-align: middle; text-align: center; padding:0; height: 10px;"> <strong>{{ $sum2 > 0 ? 'BELUM LUNAS' : 'LUNAS' }}</strong> </td>
        </tr>
    </table>
</main>
@endsection