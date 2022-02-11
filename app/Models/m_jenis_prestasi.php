<?php

namespace App\Models;

class m_jenis_prestasi extends SushiModel
{
    
    protected $primaryKey = 'id_jenis_prestasi';
    protected $schema = [
        'id_jenis_prestasi' => 'integer',
        'nama_jenis_prestasi' => 'string',
    ];

    public function getRows()
    {
        return GetDataFeeder('GetJenisPrestasi', self::$filter);
    }
}
