<?php

namespace App\Models;

class ref_jenis_sdm extends SushiModel
{
    protected $primaryKey = 'id_ikatan_kerja';
    protected $schema = [
        'id_ikatan_kerja' => 'string',
        'nama_ikatan_kerja' => 'string',
    ];

    public function getRows()
    {
        return GetDataFeeder('GetIkatanKerjaSdm');
    }
}
