<?php

namespace App\Models;

class m_tingkat_prestasi extends SushiModel
{

    protected $primaryKey = 'id_tingkat_prestasi';
    protected $schema = [
        'id_tingkat_prestasi' => 'integer',
        'nama_tingkat_prestasi' => 'string'
    ];
    
    public function getRows()
    {
        return GetDataFeeder('GetTingkatPrestasi', self::$filter);
    }
}
