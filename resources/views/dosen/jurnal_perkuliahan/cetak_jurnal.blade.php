<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Jurnal Perkuliahan {{ $matkul }}</title>
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
    <h2 align="center">JURNAL PERKULIAHAN</h2> <br>
    <div style="width:100%:margin-top:20xp;">
        <table cellpadding='3'>
            <tr>
                <td>Nama Mata Kuliah</td>
                <td align="right">  :</td>
                <td>{{ $matkul }}</td>
                <td width="300px"></td>
                <td>Jurusan</td>
                <td align="right">  :</td>
                <td>{{ $jadwal->kelas_kuliah->nama_program_studi }}</td>
            </tr>
            <tr>
                <td>Ruang/Hari</td>
                <td align="right">  :</td>
                <td>{{ $jadwal->kelas_kuliah->ruangan.', '.$jadwal->kelas_kuliah->hari}}</td>
                <td width="300px"></td>
                <td>Tahun Akademik</td>
                <td align="right">  :</td>
                <td>{{ $jadwal->kelas_kuliah->nama_semester }}</td>
            </tr>
            <tr>
                <td>Dosen Pendamping</td>
                <td style="text-align: right">  :</td>
                <td>{{ $jadwal->nama_dosen }}</td>
            </tr>
        </table>
    </div>

    <table border="1" cellpadding="6" cellspacing="0" width="100%" style="margin-top:10">
        <thead>
            <tr>
                <th align="center" width="5%">No</th>
                <th align="center" width="10%">Tgl Kuliah</th>
                <th align="center" width="10%">Tgl Input</th>
                <th align="center">Topik</th>
                <th align="center" width="10%">Jml Hadir</th>
                <th align="center" width="10%">Jml Tdk Hadir</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($jurnal as $item)
            <tr>
                <td align="center">{{ $loop->iteration }}</td>
                <td align="center">{{ date('d-m-Y', strtotime($item->tanggal_pelaksanaan)) }}</td>
                <td align="center">{{ date('d-m-Y', strtotime($item->created_at)) }}</td>
                <td>{{ $item->topik ?? '-' }}</td>
                <td align="center">{{ $item->getHadir() }}</td>
                <td align="center">{{ $item->getTidakHadir() }}</td>
                <td>
                    Mahasiswa yang tidak hadir<br>
                    <ol>
                        @foreach ($item->getMHSTidakHadir() as $item)
                            <li>{{ (isset($item->mahasiswa->nim) ? $item->mahasiswa->nim.' - ' : '').$item->mahasiswa->nama_mahasiswa }}</li>
                        @endforeach
                    </ol>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <p style="text-align: justify;">
        Jumlah Perkuliahan Terlakasana: {{ $jurnal->count() }}
    </p>
    <div style="width:80%; margin-left:auto;margin-right:auto;margin-top:29px">
        <div style="float: left;">
            Mengetahui
            <br>
            Katag Akademik
    
            <br>
            <br>
            <br>
            <p>
                {{ $jadwal->nama_dosen }} 
            </p>
        </div>
    
        <div style="float: right;">
            Jakarta, {{ date('M Y')}}
            <br>
            Dosen
    
            <br>
            <br>
            <br>
            <p>
                Dosen Tes:
            </p>
        </div>
    </div>

    {{-- <div style="float:left;"></div>
    <div style="float:right;left:0;top:0">Dicetak tanggal {{ date('d m Y')}}</div> --}}
</body>
</html>