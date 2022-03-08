@extends('layouts.pdf')

@section('title', 'SOAL-TES-TULIS-'.$registrant->kd)

@php
    $sum = round($registrant->tests()->sum('value'), 2);
    $average = round($registrant->tests()->average('value'), 2);

    $q1 = [
        'Bismillahirrahmanirrahim',
        'Alhamdulillahirabbil\'alamiin',
        'Laa ilaaha illallaahu Muhammadaurrosuulullooh',
        'Inna lillaahi wa innaa ilaihi rooji\'uun',
        'Subhanallah, Alhamdulillah, Allaahu Akbar',
        'Allahumma solli \'alaa sayyidinaa Muhammad',
        'Almuhafdzotu ala qadimis shalih wal akhdu bil jadidil ashlah'
    ];

    $q2 = config('admission.questions');
    
    $q3 = config('admission.questions-arab');
@endphp

@section('content')
<main>
    <br>
    <h4 class="center">SOAL TES TULIS ARAB</h4>
    <br>
    <table>
        <tr>
            <td width="150">Jalur pendaftaran</td>
            <td width="20">:</td>
            <td>{{ $registrant->admission->full_name }}</td>
        </tr>
        <tr>
            <td width="150">Nomor pendaftaran</td>
            <td width="20">:</td>
            <td>{{ $registrant->kd }}</td>
        </tr>
        <tr>
            <td>Nama</td>
            <td>:</td>
            <td>{{ $registrant->user->profile->full_name }}</td>
        </tr>
        <tr>
            <td>Tempat, tanggal lahir</td>
            <td>:</td>
            <td>{{ $registrant->user->profile->pdob }}</td>
        </tr>
        <tr>
            <td>Jenis kelamin</td>
            <td>:</td>
            <td>{{ $registrant->user->profile->sex_name }}</td>
        </tr>
    </table>
    <br>
    <h5 style="margin: 0px;">MATERI TULIS ARAB</h5>
    <ol style="padding-left: 1rem; margin: 0;">
        @foreach(array_rand($q1, 2) as $q)
            <li>{{ $q1[$q] }}</li>
        @endforeach
    </ol>
    @for($row = 0; $row < 6; $row++)
        <p style="border-bottom:1px solid #000; line-height: 1.3rem;">&nbsp;</p>
    @endfor
    <br>
    <h5 style="margin: 0px;">MATERI TULIS PEGON</h5>
    <ol style="padding-left: 1rem; margin: 0;">
        @foreach(array_rand($q2, 2) as $q)
            <li>{{ $q2[$q] }}</li>
        @endforeach
    </ol>
    @for($row = 0; $row < 6; $row++)
        <p style="border-bottom:1px solid #000; line-height: 1.3rem;">&nbsp;</p>
    @endfor
    <br>
    <br>
    <table>
        <tr>
            <td width="10%"></td>
            <td width="30%">
                <table cellpadding="0" cellspacing="0" border="1">
                    <tr>
                        <td class="center">NILAI</td>
                    </tr>
                    <tr>
                        <td>
                            <div style="height: 100px;"></div>
                        </td>
                    </tr>
                </table>
            </td>
            <td width="20%"></td>
            <td width="30%" class="center">
                Sleman, {{ strftime('%d %B %Y', time()) }} <br>
                Panitia PMB
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                {{ auth()->user()->profile->name }}
            </td>
            <td width="10%"></td>
        </tr>
    </table>
</main>
@if(isset($q3))
<div class="page-break">
    <main>
        <h5 style="margin: 0px;">MATERI TULIS SURAH</h5>
        <hr>
        @foreach(array_rand($q3, 2) as $q)
            @if(!$loop->last)
                <br>
            @endif
            <p><strong>{{ $q3[$q] }}</strong></p>
            @for($row = 0; $row < 9; $row++)
                <p style="border-bottom:1px solid #000; line-height: 1.3rem;">&nbsp;</p>
            @endfor
        @endforeach
    </main>
</div>
@endif
@endsection