<?php

namespace App\Models;

class ref_negara extends SushiModel
{

    protected $primaryKey = 'id_negara';
    protected $schema = [
        'id_negara' => 'string',
        'nama_negera' => 'string',
    ];
    
    public function getRows()
    {
        return GetDataFeeder('GetNegara', self::$filter);
    }
}