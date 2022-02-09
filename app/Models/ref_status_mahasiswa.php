<?php

namespace App\Models;

class ref_status_mahasiswa extends SushiModel
{
    protected $schema = [
        'id_status_mahasiswa' => 'string',
        'nama_status_mahasiswa' => 'string',
    ];

    public function getRows()
    {
        return GetDataFeeder('GetStatusMahasiswa', self::$filter);
    }
}
