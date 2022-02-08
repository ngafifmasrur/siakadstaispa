<?php

namespace App\Models;

class m_jenis_prestasi extends SushiModel
{
    
    protected $primaryKey = 'id_jenis_prestasi';
 
    public function getRows()
    {
        return GetDataFeeder('GetJenisPrestasi', self::$filter);
    }
}
