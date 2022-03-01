@extends('layouts.pdf')

@section('title', 'SURAT-KETERANGAN-DITERIMA-'.$registrant->kd)

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
            <td>{{ $registrant->kd }}/Ket.Diterima/Pan-PMB/{{ numToRoman($registrant->admission->generation) }}/{{ $registrant->admission->period->year }}</td>
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
    <p class="paragraph">Salam silaturahim kami haturkan, semoga Allah SWT senantiasa melimpahkan taufiq dan hidayah-Nya dalam menjalankan aktivitas sehari-hari. Amin. Berdasarkan ketetapan Tim Penguji pada tahap tes penjajagan dan wawancara Penerimaan Mahasiswa Baru (PMB) tahun akademik {{ $registrant->admission->period->name }}, dengan ini Ketua Panitia PMB STAI Sunan Pandanaran menerangkan bahwa:</p>
    <br>
    <table>
        <tr>
            <td width="100">Nama</td><td width="10">:</td><td><strong>{{ $registrant->user->profile->name }}</strong></td>
        </tr>
        <tr>
            <td width="100">No. Pendaftaran</td><td width="10">:</td><td><strong>{{ $registrant->kd }}</strong></td>
        </tr>
        <tr>
            <td width="100">Alamat</td><td width="10">:</td><td><strong>{{ $registrant->user->address->regional }}</strong></td>
        </tr>
        <tr>
            <td width="100">Asal Sekolah</td><td width="10">:</td><td><strong>{{ $registrant->user->studies()->where('grade_id', config('admission.maximum-grades'))->first()->name ?? '-' }}</strong></td>
        </tr>
    </table>
    <br>
    <p class="paragraph">telah dinyatakan <strong>DITERIMA</strong> sebagai mahasiswa {{ env('APP_NAME') }} T.A {{ $registrant->admission->period->name }}. Adapun ketetapan penempatan Program Studi pilihan saudara/i akan dimumkan pada bulan <strong>Agustus-September 2020</strong> berdasarkan hasil tes tulis dan tes wawancara. Demikian surat pemberitahuan ini dibuat. Atas perhatian dan kerja samanya, kami ucapkan terima kasih.</p>
    <p class="paragraph"><i>Wassalamu'alaikum Wr. Wb.</i></p>
    <br>
    <br>
    <div>
        <table width="100%">
            <tr>
                <td width="60%"></td>
                <td width="40%" class="center">
                    Yogyakarta, {{ $registrant->tested_at ? $registrant->tested_at->formatLocalized('%d %B %Y') : strftime('%d %B %Y', time()) }} <br>
                    <div>Ketua Panitia PMB</div>
                    <br><br><br><br>
                    <img src="@yield('logo', asset('/assets/img/pmb-ttd.png'))" height="80" style="position:absolute; right:35; margin-top: -70px;">
                    Dr. Rima Ronika, M.Si.<br>
                </td>
            </tr>
        </table>
    </div>
</main>
@endsection