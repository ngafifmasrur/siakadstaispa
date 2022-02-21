<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>KARTU HASIL STUDI</title>
    <style>
        header {
            margin-bottom: 20px;
        }
        header h4 {
            margin-bottom: 10px!important;
            margin-top: 0px!important;
        }

        header img {
            float: left;
            height: 40px;
        }

        .title {
            margin-bottom: 10px!important;
            margin-top: 0px!important;
            text-align: center;
            text-decoration: underline;
        }

        .description {
            width:100%;
            margin-top:20px;
            font-size:14px
        }

        footer {
            font-size: 12px;
        }

        footer .left {
            position: fixed;
            bottom: 0px;
            left: 0px; 
        }

        footer .right {
            position: fixed;
            bottom: 0px;
            right: 0px;
        }
        .titimangsa {
            position: fixed;
            right: 0px;
        }
        
    </style>
</head>
<body>
    <header>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <img src="https://pbs.twimg.com/profile_images/686406118306791424/dgoQvPm3_400x400.jpg">
        <h4>SEKOLAH TINGGI AGAMA ISLAM <br> SUNAN PANDANARAN</h4>
    </header>

    <h3 class="title">KARTU HASIL STUDI</h3>
    <div class="description">
        <table cellpadding='1'>
            <tr>
                <td>Nama Mahasiswa</td>
                <td align="right">  :</td>
                <td>{{ $riwayat_pendidikan->nama_mahasiswa }}</td>
            </tr>
            <tr>
                <td>NIM</td>
                <td align="right">  :</td>
                <td>{{ $riwayat_pendidikan->nim }}</td>
            </tr>
            <tr>
                <td>Program Studi</td>
                <td align="right">  :</td>
                <td>{{ $riwayat_pendidikan->nama_program_studi }}</td>
            </tr>
            <tr>
                <td>Semester - Tahun Akademik</td>
                <td align="right">  :</td>
                <td>{{ $nama_semester }}</td>
            </tr>
        </table>
    </div>

    <table border="1" cellpadding="6" cellspacing="0" width="100%" style="margin-top:10;font-size:13px">
        <thead>
            <tr>
                <th rowspan="2" align="center" width="5%">No</th>
                <th rowspan="2" align="center" width="12%">Kode</th>
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
    <table cellpadding='1'>
        <tr>
            <td>IP Semester saat ini</td>
            <td align="right">  :</td>
            <td>-</td>
        </tr>
        <tr>
            <td>IP Kumulatif (IPK)</td>
            <td align="right">  :</td>
            <td>-</td>
        </tr>
        <tr>
            <td>Maksimal SKS semester selanjutnya</td>
            <td align="right">  :</td>
            <td>-</td>
        </tr>
    </table>

    <div style="clear: both;"></div>
    <div class="titimangsa">
        <span>Yogyakarta, {{ Carbon\Carbon::now()->isoFormat('D MMMM YYYY')}}</span> <br>
        <span>Dosen Pembimbing Akademik</span>
        <br>
        <br>
        <br>
        <br>
        <br>
        <span style="font-weight: bold;">TONI PRANSISKA, M.Pd.</span>
    </div>

    <footer>
        <div class="left">
            Dokumen ini dicetak pada  {{ Carbon\Carbon::now()->isoFormat('D MMMM YYYY')}} pukul {{ Carbon\Carbon::now()->isoFormat('h:mm')}} WIB
        </div>
        <div class="right">
            <i>STAI Sunan Pandanaran</i>
        </div>
    </footer>

</body>
</html>