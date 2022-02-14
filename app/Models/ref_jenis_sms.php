<?php

namespace App\Models;

class ref_jenis_sms extends SushiModel
{
    protected $primaryKey = 'id_jenis_sms';
    protected $schema = [
        'id_jenis_sms' => 'string',
        'nama_jenis_sms' => 'string',
    ];
    
    public function getRows()
    {
        return GetDataFeeder('GetJenisSMS', self::$filter);
    }
}
