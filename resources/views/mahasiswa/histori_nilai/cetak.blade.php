<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>KARTU HASIL STUDI ( KHS )</title>
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
    <h2 align="center">KARTU HASIL STUDI ( KHS )</h2> <br>
    <div style="width:100%:margin-top:20xp;">
        <table cellpadding='3'>
            <tr>
                <td>Nama Mahasiswa</td>
                <td align="right">  :</td>
                <td>{{ $mahasiswa->nama_mahasiswa }}</td>
                <td width="300px"></td>
                <td>NIM</td>
                <td align="right">  :</td>
                <td>{{ $mahasiswa->nim}}</td>
            </tr>
            <tr>
                <td>Program Studi</td>
                <td align="right">  :</td>
                <td>{{ $mahasiswa->nama_program_studi }}</td>
                <td width="300px"></td>
                <td>Periode</td>
                <td align="right">  :</td>
                <td>{{ $periode }}</td>
            </tr>
        </table>
    </div>

    <table border="1" cellpadding="6" cellspacing="0" width="100%" style="margin-top:10">
        <thead>
            <tr>
                <th rowspan="2" align="center" width="5%">No</th>
                <th rowspan="2" align="center" width="12%">Kode MK</th>
                <th rowspan="2" align="center">Nama MK</th>
                <th rowspan="2" align="center" width="10%">Bobot MK (sks)</th>
                <th colspan="3" align="center" width="10%">Nilai</th>
                <th rowspan="2" align="center" width="10%">SKS * Indeks</th>
            </tr>
            <tr>
                <th align="center" width="10%">Angka</th>
                <th align="center" width="10%">Huruf</th>
                <th align="center" width="10%">Indeks</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($nilai ?? [] as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td align="center">{{ $item->kode_mata_kuliah ?? '-' }}</td>
                    <td>{{ $item->nama_mata_kuliah }}</td>
                    <td align="center">{{ $item->sks_mata_kuliah ?? '-' }}</td>
                    <td align="center">{{ $item->nilai_angka ?? '-'  }}</td>
                    <td align="center">{{ $item->nilai_huruf ?? '-'  }}</td>
                    <td align="center">{{ $item->nilai_indeks ?? '-'  }}</td>
                    <td align="center">{{ $item->total_nilai }}</td>
                </tr>
            @empty
                <tr>
                    <td align="center" colspan="8"> Data Nilai Kosong</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <th colspan="7">IPS (Indeks Prestasi Semester)</th>
                <th align="center">{{ $nilai ? $nilai->sum('total_nilai') : 0 }}</th>
            </tr>
        </tfoot>
    </table>

</body>
</html>