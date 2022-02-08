<?php

namespace App\Models;

class m_tingkat_prestasi extends SushiModel
{

    protected $primaryKey = 'id_tingkat_prestasi';

    public function getRows()
    {
        return GetDataFeeder('GetTingkatPrestasi', self::$filter);
    }
}
