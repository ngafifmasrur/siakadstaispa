<?php

namespace App\Models;

class ref_wilayah extends SushiModel
{
    protected $schema = [
        'id_wilayah' => 'string',
        'id_negara' => 'string',
        'nama_wilayah' => 'string',
    ];

    public function getRows()
    {
        return GetDataFeeder('GetWilayah', self::$filter);
    }
}
