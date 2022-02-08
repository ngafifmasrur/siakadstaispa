<?php

namespace App\Models;

class ref_jenis_evaluasi extends SushiModel
{
    protected $primaryKey = 'id_jenis_evaluasi';
    protected $schema = [
        'id_jenis_evaluasi' => 'integer',
        'nama_jenis_evaluasi' => 'string',
    ];

    public function getRows()
    {
        return GetDataFeeder('GetJenisEvaluasi', self::$filter);
    }
}
