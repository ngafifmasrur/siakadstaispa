<?php

namespace App\Models;

class t_substansi_mata_kuliah extends SushiModel
{

    protected $primaryKey = 'id_substansi';

    public function getRows()
    {
        return GetDataFeeder('GetListSubstansiKuliah', self::$filter);
    }
}
