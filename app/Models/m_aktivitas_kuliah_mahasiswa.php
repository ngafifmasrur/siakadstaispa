<?php

namespace App\Models;

class m_aktivitas_kuliah_mahasiswa extends SushiModel
{
    protected $schema = [
        'id_registrasi_mahasiswa' => 'uuid',
        'id_mahasiswa' => 'uuid',
        'id_semester' => 'uuid',
        'nama_semester' => 'string',
        'nim' => 'string',
        'nama_mahasiswa' => 'string',
        'angkatan' => 'integer',
        'id_prodi' => 'uuid',
        'nama_program_studi' => 'string',
        'id_status_mahasiswa' => 'string',
        'nama_status_mahasiswa' => 'string',
        'ips' => 'float',
        'ipk' => 'float',
        'sks_semester' => 'float',
        'sks_total' => 'float',
        'biaya_kuliah_smt' => 'float'
    ];

    public function getRows()
    {
        return GetDataFeeder('GetAktivitasKuliahMahasiswa', self::$filter);
    }
}
