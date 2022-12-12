@extends('layouts.pdf')

@section('title', 'SURAT-PERJANJIAN-'.$registrant->kd)

@php
    
    $list = [
        'No Daftar' => $registrant->kd,
        'Nama Orang tua' => $registrant->user->father->name.'/'.$registrant->user->mother->name,
        'Alamat' => $registrant->user->address->full,
        'No Telp' => $registrant->user->nomor_hp ??  '-',,
        'Status' => 'Orang tua/wali calon mahasiswa',
        'Nama Santri' => $registrant->user->profile->full_name,
    ];

    $items = [
        'Memahami dengan jelas setiap peraturan yang ada di Pondok Pesantren Sunan Pandanaran dan addendumnya,',
        'Mendukung dan menghormati sistem pendidikan yang ada di Pesantren dan Madrasah/Sekolah ini, ',
        'Tidak melakukan upaya dan atau dukungan kepada anak saya dalam hal melanggar Peraturan Pesantren dan Madrasah/Sekolah, seperti : Keluar tanpa ijin, membawa barang-barang yang dilarang, dan lain-lain,',
        'Apabila terjadi permasalahan terhadap proses pendidikan yang ada di Pesantren dan Madrasah/Sekolah terkait dengan perkembangan anak saya, maka akan saya upayakan secara kekeluargaan dengan tanpa melibatkan pihak ketiga, dan tunduk terhadap peraturan yang berlaku di Pesantren atau Madrasah/Sekolah,',
        'Tidak menyalahkan Pesantren apabila terdapat kejadian-kejadian di luar lingkungan Pesantren terhadap putra/putrinya yang pada saat itu tidak mendapatkan ijin untuk pergi keluar Pesantren,',
        'Akan selalu menjaga nama baik Pondok Pesantren Sunan Pandanaran.',
    ];

@endphp

@section('content')
<main>
    <p class="center"><strong><u>SURAT PERJANJIAN</u></strong></p>
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
    <p>Dengan ini, secara sadar membuat pernyataan bahwa saya :</p>
    <br>
    <table>
        @foreach($items as $item)
            <tr>
                <td width="16" style="padding-left: 2rem;">{{ $loop->iteration }}.</td>
                <td>{{ $item }}</td>
            </tr>
        @endforeach
    </table>
    <br>
    <p>Demikian surat pernyataan ini saya buat dengan sungguh-sungguh, tanpa ada paksaan dari pihak manapun.</p>
    <br>
    <table class="center" style="position: fixed; bottom: 8.5cm;">
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