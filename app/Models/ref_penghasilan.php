<?php

namespace App\Models;

class ref_penghasilan extends SushiModel
{
    protected $primaryKey = 'id_penghasilan';
    protected $schema = [
        'id_penghasilan' => 'string',
        'nama_penghasilan' => 'string',
    ];
    
    public function getRows()
    {
        return GetDataFeeder('GetPenghasilan', self::$filter);
    }
}
