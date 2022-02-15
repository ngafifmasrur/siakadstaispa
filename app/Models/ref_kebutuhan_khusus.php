<?php

namespace App\Models;

class ref_kebutuhan_khusus extends SushiModel
{
    protected $primaryKey = 'id_kebutuhan_khusus';
    protected $schema = [
        'id_kebutuhan_khusus' => 'integer',
        'nama_kebutuhan_khusus' => 'string',
    ];
    
    public function getRows()
    {
        return GetDataFeeder('GetKebutuhanKhusus', self::$filter);
    }
}
