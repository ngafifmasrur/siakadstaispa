<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>KARTU HASIL STUDI ( KHS )</title>
    <style>
        footer {
            position: fixed; 
            bottom: 0px; 
            left: 0px; 
            right: 0px;
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
            <span style="font-size:13px;"> Website: www.staispa.ac.id., Email: staispayogyakarta@gmail.com, Telp. (0274) 4543912 / 4543913 </span>
        </div>
    </header>
    <hr style="margin-top:10px;">
    <h4 align="center" style="margin-bottom: 10px!important;margin-top: 0px!important">KARTU HASIL STUDI SEMESTER</h4>
    <div style="width:100%:margin-top:20xp;font-weight:bold;font-size:13px">
        <table cellpadding='1'>
            <tr>
                <td>NIM</td>
                <td align="right">  :</td>
                <td>{{ $riwayat_pendidikan->nim }}</td>
            </tr>
            <tr>
                <td>Nama Mahasiswa</td>
                <td align="right">  :</td>
                <td>{{ $riwayat_pendidikan->nama_mahasiswa }}</td>
            </tr>
            <tr>
                <td>Program Studi</td>
                <td align="right">  :</td>
                <td>{{ $riwayat_pendidikan->nama_program_studi }}</td>
            </tr>
            <tr>
                <td>Semester/Tahun</td>
                <td align="right">  :</td>
                <td>{{ $nama_semester }}</td>
            </tr>
        </table>
    </div>

    <table border="1" cellpadding="6" cellspacing="0" width="100%" style="margin-top:10;font-size:13px">
        <thead>
            <tr>
                <th rowspan="2" align="center" width="5%">No</th>
                <th rowspan="2" align="center" width="12%">Kode MK</th>
                <th rowspan="2" align="center">Mata Kuliah</th>
                <th rowspan="2" align="center" width="10%">SMT</th>

                <th rowspan="2" align="center" width="10%">SKS</th>
                <th colspan="3" align="center" width="10%">Nilai</th>
            </tr>
            <tr>
                <th align="center" width="10%">Huruf</th>
                <th align="center" width="10%">Bobot</th>
                <th align="center" width="10%">Mutu</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($nilai ?? [] as $item)
                <tr>
                    <td align="center">{{ $loop->iteration }}</td>
                    <td align="center">{{ $item->kode_mata_kuliah ?? '-' }}</td>
                    <td>{{ $item->nama_mata_kuliah }}</td>
                    <td align="center">{{ $item->semester ?? '-' }}</td>
                    <td align="center">{{ $item->sks_mata_kuliah ?? '-' }}</td>
                    <td align="center">{{ $item->nilai_huruf ?? '-'  }}</td>
                    <td align="center">{{ $item->nilai_indeks ?? '-'  }}</td>
                    <td align="center">{{ $item->nilai_indeks*$item->sks_mata_kuliah }}</td>
                </tr>
            @empty
                <tr>
                    <td align="center" colspan="8"> Data Nilai Kosong</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <th colspan="4">Jumlah SKS</th>
                <th align="center">{{ $nilai ? $nilai->sum('sks_mata_kuliah') : 0 }}</th>
                <th colspan="2">Jumlah Nilai</th>
                <th align="center">{{ $nilai ? $nilai->sum('total_nilai') : 0 }}</th>
            </tr>
        </tfoot>
    </table>
    <br>
    IP Semester saat ini: -

    <footer>
        <table style="width: 100%;font-size:14px;">
            <tbody>
                <tr>
                    <td>
                        <br>
                        <div style="margin-right:200px;">
                            <span style="margin-left:20px;">Mengetahui,</span>
                            <br>
                            an. Kepala Sekolah Tinggi.
                            <br><span style="margin-left:20px;">Pembantu Ketua</span>
                            <br><span style="margin-left:20px;">Bidang Akademik, Kemahasiswaan,</span>
                            <br><span style="margin-left:20px;">dan Administrasi</span>
    
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <p style="margin-left:20px;">
                                <strong><u>-</u></strong>
                                <br>
                                NIK. 
                            </p>
                        </div>
    
                    </td>
    
                    <td>
                        <br>
                        <div style="margin-left:-200px;">
                            <span style="margin-left:20px;">Yogyakarta, {{ Carbon\Carbon::now()->isoFormat('D MMMM YYYY')}}</span>
                            <br>
                            <br>
                            an. Ketua Program Studi.
                            <br><span style="margin-left:20px;">Sekertaris Program Studi.</span>
    
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <p style="margin-left:20px;">
                                <strong><u>-</u></strong>
                                <br>
                                NIK. 
                            </p>
                        </div>
    
                    </td>
                </tr>
            </tbody>
        </table>
    </footer>

</body>
</html>