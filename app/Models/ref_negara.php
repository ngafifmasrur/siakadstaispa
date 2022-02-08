<?php

namespace App\Models;

class ref_negara extends SushiModel
{

    protected $primaryKey = 'id_negara';

    public function getRows()
    {
        return GetDataFeeder('getNegara', self::$filter);
    }
}
