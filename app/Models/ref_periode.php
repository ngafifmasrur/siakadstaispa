<?php

namespace App\Models;

class ref_periode extends SushiModel
{
    protected $primaryKey = 'id_periode';

    public function getRows()
    {
        return GetDataFeeder('GetPeriode', self::$filter);
    }
}
