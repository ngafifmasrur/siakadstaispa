<?php

namespace App\Models;

class ref_pekerjaan extends SushiModel
{
    protected $primaryKey = 'id_pekerjaan';
    protected $schema = [
        'id_pekerjaan' => 'string',
        'nama_pekerjaan' => 'string',
    ];
    
    public function getRows()
    {
        return GetDataFeeder('GetPekerjaan', self::$filter);
    }
}
