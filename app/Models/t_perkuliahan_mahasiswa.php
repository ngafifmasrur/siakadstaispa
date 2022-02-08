<?php

namespace App\Models;

class t_perkuliahan_mahasiswa extends SushiModel
{
    protected $schema = [
        'id_registrasi_mahasiswa' => 'uuid',
        'nim' => 'string',
        'nama_mahasiswa' => 'string',
        'id_prodi' => 'uuid',
        'nama_program_studi' => 'string',
        'angkatan' => 'integer',
        'id_periode_masuk' => 'integer',
        'id_semester' => 'integer',
        'nama_semester' => 'string',
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
        return GetDataFeeder('GetListPerkuliahanMahasiswa', self::$filter);
    }
}