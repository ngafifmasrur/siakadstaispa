@extends('layouts.pdf')

@section('title', 'SURAT-KETERANGAN-LULUS-'.$registrant->kd)

@php
    $sum = round($registrant->tests()->sum('value'), 2);
    $average = round($registrant->tests()->average('value'), 2);
@endphp

@section('content')
<main>
    <table>
        <tr>
            <td>No</td>
            <td>:</td>
            <td>{{ $registrant->kd }}/Pan-PMB/TT/{{ numToRoman($registrant->admission->generation) }}/{{ $registrant->admission->period->instance->short_name }}/{{ $registrant->admission->period->year }}</td>
        </tr>
        <tr>
            <td>Hal</td>
            <td>:</td>
            <td>Pengumuman</td>
        </tr>
    </table>
    <br>
    <p>Kepada Yth.</p>
    <p>Bapak/Ibu calon mahasiswa</p>
    <p>Di tempat,</p>
    <br>
    <p class="paragraph"><i>Assalamu'alaikum Wr. Wb.</i></p>
    <p class="paragraph">Salam silaturahim kami haturkan, semoga Allah SWT senantiasa melimpahkan taufiq dan hidayah-Nya dalam menjalankan aktivitas sehari-hari. Amin. Berdasarkan hasil tes dan rapat panitia Penerimaan Mahasiswa Baru (PMB) tahun pelajaran {{ $registrant->admission->period->name }}, maka putra/i Bapak/Ibu yang bernama:</p>
    <h2 class="center" style="padding: 10px 0;"><u>{{ $registrant->user->profile->name }}</u></h2>
    <p class="center">dinyatakan</p>
    <h3 class="center" style="padding: 10px 0;">{{ ($registrant->tested_at ? 'LULUS TES' : 'BELUM LULUS TES') }}</h3>
    @if(count($registrant->tests))
        <p class="center">Keputusan tersebut berdasarkan hasil tes dengan rincian nilai sebagai berikut:</p>
        <table class="table">
            @foreach($registrant->tests as $test)
                <tr>
                    <td nowrap>{{ $test->name }}</td>
                    <td @if($test->pivot->value < $test->minimal) style="color:red;" @endif>{{ $test->pivot->value ?: 0 }}</td>
                    <td class="muted">{{ $test->pivot->description }}</td>
                </tr>
            @endforeach
            <tr style="font-weight: bold;">
                <td nowrap>Jumlah</td>
                <td>{{ $sum }}</td>
                <td></td>
            </tr>
            <tr style="font-weight: bold;">
                <td nowrap>Rata-rata</td>
                <td>{{ $average }}</td>
                <td></td>
            </tr>
        </table>
    @endif
    <br>
    <p class="paragraph">Demikian surat pemberitahuan ini dibuat. Atas perhatian dan kerja samanya, kami ucapkan terima kasih.</p>
    <p class="paragraph"><i>Wassalamu'alaikum Wr. Wb.</i></p>
    <br>
    <br>
    <div>
        <table width="100%">
            <tr>
                <td width="60%"></td>
                <td width="40%" class="center">
                    Yogyakarta, {{ $registrant->tested_at ? $registrant->tested_at->formatLocalized('%d %B %Y') : strftime('%d %B %Y', time()) }} <br>
                    <div>Panitia PMB</div>
                    <br><br><br><br>
                    {{ auth()->user()->profile->full_name ?: '........' }}<br>
                </td>
            </tr>
        </table>
    </div>
</main>
@endsection