<?php

namespace App\Models;

class ref_jenjang_pendidikan extends SushiModel
{
    protected $primaryKey = 'id_jenjang_didik';
    protected $schema = [
        'id_jenjang_didik' => 'string',
        'nama_jenjang_didik' => 'string',
    ];
    
    public function getRows()
    {
        return GetDataFeeder('GetJenjangPendidikan', self::$filter);
    }
}
