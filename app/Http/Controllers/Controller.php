<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public $jenjang_pendidikan = [
        '22' => 'D3',
        '23' => 'D4',
        '30' => 'S1',
    ];

    public $status_prodi = [
        'A' => 'Aktif',
        'B' => 'Alih Bentuk',
        'H' => 'Hapus',
        'K' => 'Ahli Kelola',
        'M' => 'Merger',
        'N' => 'Non Aktif',
    ];

    public $jenis_matkul = [
        'A' => 'Wajib',
        'B' => 'Pilihan',
        'C' => 'Wajib Peminatan',
        'D' => 'Pilihan Peminatan',
        'S' => 'Tugas akhir/Skripsi/Tesis/Disertasi',
    ];

    public $kelompok_matkul = [
        'A' => 'MPK',
        'B' => 'MKK',
        'C' => 'MKB',
        'D' => 'MPB',
        'E' => 'MBB',
        'F' => 'MKU/MKDU',
        'G' => 'MKDK',
        'H' => 'MKK',
    ];

    public $status_mahasiswa = [
        'A' => 'Aktif',
        'C' => 'Cuti',
        'G' => 'Sedang Double Degree',
        'N' => 'Non Aktif',
    ];

    public $jalur_daftar = [
        '1' => 'SBMPTN',
        '2' => 'SNMPTN',
        '3' => 'PMDK',
    ];

}
