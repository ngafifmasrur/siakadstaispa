<?php

namespace App\Models;

class ref_jenis_tinggal extends SushiModel
{
    protected $primaryKey = 'id_jenis_tinggal';
    protected $schema = [
        'id_jenis_tinggal' => 'string',
        'nama_jenis_tinggal' => 'string',
    ];
    
    public function getRows()
    {
        return GetDataFeeder('GetJenisTinggal', self::$filter);
    }
}
