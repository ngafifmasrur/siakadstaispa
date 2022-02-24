<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>TRANSKRIP NILAI</title>
    <style>
        html {
            border: 0px;
            margin: 20px;
        }
    </style>
</head>
<body>
    <header>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <img src="https://pbs.twimg.com/profile_images/686406118306791424/dgoQvPm3_400x400.jpg" style="float: left;
        height: 78px">
        
        <div style="text-align:center;">
            <h4 style="margin-bottom: 10px!important;margin-top: 0px!important">SEKOLAH TINGGI AGAMA ISLAM SUNAN PANDANARAN (STAISPA)</h4>
            <span style="font-size:13px;"> Kl. Kaliurang Km. 12,5 Candi, Sardonoharjo, Ngaglik, Sleman, Yogyakarta, 55581 </span><br>
            <span style="font-size:13px;"> Website: www.staisunanpandanaran.ac.id, Email: staispayogyakarta@gmail.com, Telp. (0274) 4543912 / 4543913 </span>
        </div>
    </header>
    <hr style="margin-top:10px;">
    <h4 align="center" style="margin-bottom: 10px!important;margin-top: 0px!important">TRANSKRIP NILAI</h4>
    <div style="width:100%:margin-top:20xp;font-weight:bold;font-size:13px">
        <table cellpadding='1' align="center">
            <tr>
                <td>Nama Mahasiswa</td>
                <td align="right">  :</td>
                <td>{{ $riwayat_pendidikan->nama_mahasiswa }}</td>
                <td width="160px"></td>
                <td>Program Studi</td>
                <td align="right">  :</td>
                <td>{{ $riwayat_pendidikan->nama_program_studi }}</td>

            </tr>
            <tr>
                <td>Tempat Lahir</td>
                <td align="right">  :</td>
                <td>-</td>
                <td width="160px"></td>
                {{-- <td>Gelar Akademik</td>
                <td align="right">  :</td>
                <td>-</td> --}}
            </tr>
            <tr>
                <td>Tanggal Lahir</td>
                <td align="right">  :</td>
                <td>{{ $riwayat_pendidikan->tanggal_lahir}}</td>
                <td width="160px"></td>
                {{-- <td>No Ijazah Nasional</td>
                <td align="right">  :</td>
                <td>-</td> --}}
            </tr>
            <tr>
                <td>NIM</td>
                <td align="right">  :</td>
                <td>{{ $riwayat_pendidikan->nim}}</td>
                <td width="160px"></td>
                {{-- <td>No. Pendirian PTKI</td>
                <td align="right">  :</td>
                <td>{{ $nama_semester_aktif  }}</td> --}}
            </tr>
            <tr>
                <td>Tanggal Lulus</td>
                <td align="right">  :</td>
                <td>{{ $mahasiswa_lulus->tanggal_keluar ?? '-'}}</td>
                <td width="160px"></td>
                {{-- <td>No. SK-BAN-PT</td>
                <td align="right">  :</td>
                <td>-</td> --}}
            </tr>
        </table>
    </div>

    <div class="transkrip" style="width:49%;float:left">
        <table border="1" cellpadding="3" cellspacing="0" width="100%" style="margin-top:10;font-size:10px;border: 2px solid black">
            <thead>
                <tr>
                    <th rowspan="2" align="center" width="10%">No</th>
                    <th rowspan="2" align="center" width="20%">Kode MK</th>
                    <th rowspan="2" align="center" width="50%">Mata Kuliah</th>
                    <th rowspan="2" align="center" width="10%">SKS</th>
                    <th colspan="2" align="center" width="20%">Nilai</th>
                </tr>
                <tr>
                    <th calign="center">Huruf</th>
                    <th calign="center">Bobot</th>
    
                </tr>
            </thead>
            <tbody>
                @forelse ($transkrip->slice(0, 34) ?? [] as $item)
                    <tr>
                        <td align="center">{{ $loop->iteration }}</td>
                        <td align="center">{{ $item->kode_mata_kuliah ?? '-' }}</td>
                        <td align="left">{{ ucwords(strtolower($item->nama_mata_kuliah)) }}</td>
                        <td align="center">{{ $item->sks_mata_kuliah ?? '-'  }}</td>
                        <td align="center">{{ $item->nilai_huruf ?? '-'  }}</td>
                        <td align="center">{{ $item->nilai_indeks ?? '-'  }}</td>
                    </tr>
                @empty
                    <tr>
                        <td align="center" colspan="6"> Data Transkrip Kosong</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($transkrip->count() >= 34)
    <div class="transkrip" style="width:49%;float:right">
        <table border="1" cellpadding="3" cellspacing="0" width="100%" style="margin-top:10;font-size:10px;border: 2px solid black">
            <thead>
                <tr>
                    <th rowspan="2" align="center" width="10%">No</th>
                    <th rowspan="2" align="center" width="20%">Kode MK</th>
                    <th rowspan="2" align="center" width="50%">Mata Kuliah</th>
                    <th rowspan="2" align="center" width="10%">SKS</th>
                    <th colspan="2" align="center" width="20%">Nilai</th>
                </tr>
                <tr>
                    <th calign="center">Huruf</th>
                    <th calign="center">Bobot</th>

                </tr>
            </thead>
            <tbody>
                @forelse ($transkrip->slice(34, $transkrip->count()) ?? [] as $item)
                    <tr>
                        <td align="center">{{ $loop->iteration+34 }}</td>
                        <td align="center">{{ $item->kode_mata_kuliah ?? '-' }}</td>
                        <td align="left">{{ ucwords(strtolower($item->nama_mata_kuliah)) }}</td>
                        <td align="center">{{ $item->sks_mata_kuliah ?? '-'  }}</td>
                        <td align="center">{{ $item->nilai_huruf ?? '-'  }}</td>
                        <td align="center">{{ $item->nilai_indeks ?? '-'  }}</td>
                    </tr>
                @empty
                    <tr>
                        <td align="center" colspan="6"> Data Transkrip Kosong</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @php
            $nilai_mutu = $transkrip->sum('sks_mata_kuliah')+$transkrip->sum('nilai_indeks');
        @endphp
        <table cellpadding="3" cellspacing="0" width="100%" style="margin-top:10;font-size:10px;font-weight:bold;border: 2px solid black">
            <tbody>
                <tr>
                    <td>Semester yang ditempuh</td>
                    <td align="right"> :</td>
                    <td>{{ $total_semester }}</td>
                </tr>
                {{-- <tr>
                    <td>Total nilai mutu</td>
                    <td align="right"> :</td>
                    <td>{{ $nilai_mutu }}</td>
                </tr>
                <tr>
                    <td>Total SKS</td>
                    <td align="right"> :</td>
                    <td>{{ $transkrip->sum('sks_mata_kuliah')*$nilai_mutu }}</td>
                </tr>
                <tr>
                    <td>Indeks Prestasi Kumulatif (IPK)</td>
                    <td align="right"> :</td>
                    <td>-</td>
                </tr>
                <tr>
                    <td>Predikat</td>
                    <td align="right"> :</td>
                    <td>-</td>
                </tr> --}}
            </tbody>
        </table>

    </div>

    @else
    <div style="clear: both;"></div>
    <div class="transkrip" style="width:49%;float:left">
    <table border="1" cellpadding="3" cellspacing="0" width="100%" style="margin-top:10;font-size:10px;font-weight:bold">
        <tbody>
            <tr>
                <td>Semester yang ditempuh</td>
                <td align="right"> :</td>
                <td>-</td>
            </tr>
            <tr>
                <td>Total nilai mutu</td>
                <td align="right"> :</td>
                <td>-</td>
            </tr>
            <tr>
                <td>Total SKS</td>
                <td align="right"> :</td>
                <td>-</td>
            </tr>
            <tr>
                <td>Indeks Prestasi Kumulatif (IPK)</td>
                <td align="right"> :</td>
                <td>-</td>
            </tr>
            <tr>
                <td>Predikat</td>
                <td align="right"> :</td>
                <td>-</td>
            </tr>
        </tbody>
    </table>
    </div>
    @endif

    <div style="clear: both;"></div>
    {{-- <table border="1" cellpadding="6" cellspacing="0"  width="100%"style="margin-top:10px;margin-bottom:20px;font-size:10px;font-weight:bold;border: 2px solid black">
        <tbody>
            <tr>
            <td align="left">Judul Skripsi : {{ $mahasiswa_lulus->judul_skripsi ?? '-' }}</td>
            </tr>
        </tbody>
    </table> --}}

    {{-- <div class="keterangan" style="float: left;font-size:10px;font-weight:bold">
        <u>Keterangan</u><br>
        3.51 - 4.00 : Cumlaude <br>
        3.00 - 3.50 : Sangat Memuaskan Wakil Ketua Bidang Akademik dan Penelitian<br>
        2.50 - 2.99 : Memuaskan<br>
        2.00 - 2.49 : Cukup<br>
        0,00 - 1.99 : Gagal/Tidak Lulus
    </div> --}}

    <div style="float: right;font-size:10px;font-weight:bold">
        Sleman, {{ Carbon\Carbon::now()->isoFormat('D MMMM YYYY')}} <br>
        Wakil Ketua Bidang Akademik dan Penelitian<br><br><br><br>
        -
    </div>

</body>
</html>