<?php

namespace App\Models;

class ref_agama extends SushiModel
{

    protected $primaryKey = 'id_agama';

    public function getRows()
    {
        return GetDataFeeder('GetAgama', self::$filter);
    }
}
