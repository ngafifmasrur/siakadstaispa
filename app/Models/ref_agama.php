<?php

namespace App\Models;

class ref_agama extends SushiModel
{

    protected $primaryKey = 'id_agama';
    protected $schema = [
        'id_agama' => 'integer',
        'nama_agama' => 'string',
    ];

    public function getRows()
    {
        return GetDataFeeder('GetAgama', self::$filter);
    }
}
