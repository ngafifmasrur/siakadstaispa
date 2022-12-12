@extends('layouts.pdf')

@section('title', 'SURAT-PERJANJIAN-ALUMNI-'.$registrant->kd)

@php
    
    $list = [
        'Nama Orang tua' => $registrant->user->father->name.'/'.$registrant->user->mother->name,
        'Alamat' => $registrant->user->address->full,
        'No Telp' => $registrant->user->nomer_hp ?? '-',
        'Status' => 'Orang tua/wali calon mahasiswa',
    ];

@endphp

@section('content')
<main>
    <p class="center"><strong><u>SURAT PERJANJIAN ALUMNI</u></strong></p>
    <br>
    <p>Yang bertanda tangan di bawah ini adalah :</p>
    <br>
    <table>
        @foreach($list as $name => $value)
            <tr>
                <td width="100">{{ $name }}</td>
                <td width="5">:</td>
                <td><strong>{{ $value }}</strong></td>
            </tr>
        @endforeach
    </table>
    <br>
    <p>Dengan ini menyatakan bahwa anak saya :</p>
    <table>
        <tr>
            <td width="100">Nama</td>
            <td width="5">:</td>
            <td><strong>{{ $registrant->user->profile->full_name }}</strong></td>
        </tr>
        <tr>
            <td width="100">Jurusan/kelas</td>
            <td width="5">:</td>
            <td><strong>{{ config('admission.sex-transform')[$registrant->user->profile->sex] }}</strong></td>
        </tr>
        <tr>
            <td width="100">Jenis pelanggaran</td>
            <td width="5">:</td>
            <td>
                <div style="height:20px; border-bottom:1px solid #000;">&nbsp;</div>
                <div style="height:20px; border-bottom:1px solid #000;">&nbsp;</div>
                <div style="height:20px; border-bottom:1px solid #000;">&nbsp;</div>
                <div style="height:20px; border-bottom:1px solid #000;">&nbsp;</div>
                <div style="height:20px; border-bottom:1px solid #000;">&nbsp;</div>
                <small>(Yang pernah dilakukan)</small>
            </td>
        </tr>
    </table>
    <br>
    <p>Telah berubah menjadi lebih baik dan siap untuk kembali belajar di lingkungan Pondok Pesantren dan Madrasah Sunan Pandanaran.</p>
    <br>
    <p>Apabila di kemudian hari, anak tersebut melakukan pelanggaran peraturan yang ada di Pondok Pesantren dan atau Madrasah Sunan Pandanaran, maka saya siap untuk diberikan sanksi dalam bentuk apapun, termasuk anak tersebut di kembalikan ke orang tua/walinya.</p>
    <br>
    <p>Demikian surat pernyataan ini dibuat dengan sebenar-benarnya untuk kebaikan bersama dalam menjaga sistem pendidikan dan pengajaran di pesantren dan madrasah ini, serta dibuat dengan tanpa ada paksaan apapun.</p>
    <br>
    <table class="center" style="position: fixed; bottom: 9cm;">
        <tr>
            <td width="5%"></td>
            <td width="30%"></td>
            <td width="40%">
                Sleman, {{ strftime('%d %B %Y') }} <br> 
                Yang menyatakan,
            </td>
            <td width="30%"></td>
            <td width="5%"></td>
        </tr>
        <tr>
            <td></td>
            <td>
                Orang tua/wali calon mahasiswa <br><br><br><br><br><br>
                ({{ $registrant->user->father->name.'/'.$registrant->user->mother->name }})
            </td>
            <td></td>
            <td>
                Calon mahasiswa <br><br><br><br><br><br>
                ({{ $registrant->user->profile->full_name }})
            </td>
            <td></td>
        </tr>
        <tr>
            <td width="5%"></td>
            <td width="30%"></td>
            <td width="40%">
                <br> Mengetahui, <br> Panitia {{ config('admission.app.name') }}<br><br><br><br><br><br>
                ({{ auth()->user()->profile->full_name }})
            </td>
            <td width="30%"></td>
            <td width="5%"></td>
        </tr>
    </table>
</main>
@endsection