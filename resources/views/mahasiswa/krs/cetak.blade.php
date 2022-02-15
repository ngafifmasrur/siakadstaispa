<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>KARTU RENCANA STUDI ( KRS )</title>
</head>
<body>
    <header>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <img src="https://pbs.twimg.com/profile_images/686406118306791424/dgoQvPm3_400x400.jpg" style="float: left;
        height: 110px;">
        {{-- <img src="{{public_path('/img/logo-mts.jpeg')}}" style="float: right;
        height: 80px;"> --}}
        
        <div style="text-align:left;">
            <span style="font-size:25px;font-weight:bold;align-items:center;"> KEMENTERIAN AGAMA REPUBLIK INDONESIA </span><br>
            <span style="font-size:25px;font-weight:bold;align-items:center;"> STAI Sunan Pandanaran Yogyakarta </span><br>
            <span style="font-size:16px;font-weight:bold"> Alamat: Jl. Kaliurang Km. 12,5, Candi, Sardonoharjo, Ngaglik. </span>  <br>
            <span style="font-size:16px;font-weight:bold">Telp (0274) 7496585, 8808. Faxmile (0274) 880857</span>
        </div>
    </header>
    <hr style="margin-top:20px;">
    <h2 align="center">KARTU RENCANA STUDI ( KRS )</h2> <br>
    <div style="width:100%:margin-top:20xp;">
        <table cellpadding='3'>
            <tr>
                <td>Nama Mahasiswa</td>
                <td align="right">  :</td>
                <td>{{ $riwayat_pendidikan->nama_mahasiswa }}</td>
                <td width="300px"></td>
                <td>NIM</td>
                <td align="right">  :</td>
                <td>{{ $riwayat_pendidikan->nim}}</td>
            </tr>
            <tr>
                <td>Program Studi</td>
                <td align="right">  :</td>
                <td>{{ $riwayat_pendidikan->nama_program_studi }}</td>
                <td width="300px"></td>
                <td>Semester</td>
                <td align="right">  :</td>
                <td>{{ $nama_semester_aktif  }}</td>
            </tr>
        </table>
    </div>

    <table border="1" cellpadding="6" cellspacing="0" width="100%" style="margin-top:10">
        <thead>
            <tr>
                <th align="center" width="5%">No</th>
                <th>Nama Mata Kuliah</th>
                <th align="center" width="12%">Kelas</th>
                <th align="center" width="10%">Ruangan</th>
                <th align="center" width="10%">SKS</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($krs ?? [] as $item)
                <tr>
                    <td align="center">{{ $loop->iteration }}</td>
                    <td>{{ $item->nama_mata_kuliah ?? '-' }}</td>
                    <td align="center">{{ $item->nama_kelas_kuliah }}</td>
                    <td align="center">{{ $item->ruangan ?? '-'  }}</td>
                    <td align="center">{{ $item->sks_mata_kuliah ?? '-'  }}</td>
                </tr>
            @empty
                <tr>
                    <td align="center" colspan="5"> Data KRS Kosong</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <th colspan="4">Jumlah SKS</th>
                <th align="center">{{ $krs ? $krs->sum('sks_mata_kuliah') : 0 }}</th>
            </tr>
        </tfoot>
    </table>

</body>
</html>