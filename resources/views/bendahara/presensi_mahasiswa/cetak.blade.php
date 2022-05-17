<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>REKAP PRESENSI MAHASISWA {{ $mahasiswa->nama_mahasiswa }}</title>
    <style>
        html {
            border: 0px;
            margin: 20px;
        }

        .logo-background {
            background-image: url(https://i.ibb.co/Tk0JHSX/output-onlinepngtools-2.png);
            background-size: 28%;
            background-repeat: no-repeat;
            background-position: center;
            /* top: -100px; */
        }
    </style>
</head>
<body>
    <header>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <img src="https://pbs.twimg.com/profile_images/686406118306791424/dgoQvPm3_400x400.jpg" style="float: left;
        height: 78px">
        
        <div style="text-align:left;">
            <h4 style="margin-bottom: 6px!important;margin-top: 0px!important">SEKOLAH TINGGI AGAMA ISLAM SUNAN PANDANARAN (STAISPA)</h4>
            <span style="font-size:13px;"> Kl. Kaliurang Km. 12,5 Candi, Sardonoharjo, Ngaglik, Sleman, Yogyakarta, 55581 </span><br>
            <span style="font-size:13px;"> Telp. (0274) 4543912 / 4543913 </span>
        </div>
    </header>
    <hr style="margin-top:14px;">
    <h4 align="center" style="margin-bottom: 10px!important;margin-top: 0px!important;text-decoration: underline;">PRESENSI: {{ $mahasiswa->nama_mahasiswa }}</h4>
    {{-- <div style="width:100%:margin-top:20xp;font-size:13px">
        <table cellpadding='1' align="center">
            <tr>
                <td>Prodi</td>
                <td align="right">  :</td>
                <td>{{ $kelas->nama_program_studi }}</td>
                <td width="160px"></td>
                <td>Hari, Jam</td>
                <td align="right">  :</td>
                <td>{{ $jadwal->hari.', '.$jadwal->jam_mulai.' - '.$jadwal->jam_akhir }}</td>
                <td width="160px"></td>
                <td>Ruang</td>
                <td align="right">  :</td>
                <td>-</td>
            </tr>
            <tr>
                <td>Tahun Akademik</td>
                <td align="right">  :</td>
                <td>{{ $kelas->nama_semester }}</td>
                <td width="160px"></td>
                <td>Dosen Pengampu</td>
                <td align="right">  :</td>
                <td>{{ $dosen->nama_dosen }}</td>
                <td width="160px"></td>
                <td>Kelas</td>
                <td align="right">  :</td>
                <td>{{ $kelas->nama_kelas_kuliah }}</td>
            </tr>
        </table>
    </div> --}}

    @php
        $total_junal = $jurnal->count();
        $tambahan_kolom = 16-$total_junal;
    @endphp
    <table class="logo-background" border="1" cellpadding="1" cellspacing="0" width="100%" style="margin-top:10;font-size:10px;">
        <tr>
            <th width="5%" align="center">NO</th>
            <th width="8%" align="center">Kode Matkul</th>
            <th width="18%" align="center">Nama Matkul</th>
            @for($i = 1; $i <= 16; $i++)
                <th align="center" class="border border-gray-400">{{ $i }}</th>
            @endfor
        </tr>
        @foreach ($list_kelas as $kelas)
            <tr>
                <td align="center">{{ $loop->iteration }}</td>
                <td align="center">{{ $kelas->kode_mata_kuliah }}</td>
                <td align="left">{{ $kelas->nama_mata_kuliah }}</td>
                @for($i = 1; $i <= 16; $i++)
                <td align="center" class="border border-gray-400">
                    @if(isset($jurnal->where('id_kelas_kuliah', $kelas->id_kelas_kuliah)->where('pertemuan_ke', $i)->first()->id))
                        @switch($absensi->where('id_jurnal_kuliah', $jurnal->where('id_kelas_kuliah', $kelas->id_kelas_kuliah)->where('pertemuan_ke', $i)->first()->id)->where('id_mahasiswa', $mahasiswa->id_mahasiswa)->first()->status ?? '-')
                            @case("Hadir")
                                H
                                @break
                            @case('Sakit')
                                S
                                @break
                            @case('Ijin')
                                I
                                @break
                            @case('Alpa')
                                A
                                @break
                            @default
                                -
                        @endswitch
                    @else
                        
                    @endif
                </td>
                @endfor
            </tr>   
        @endforeach
    </table>

</body>
</html>