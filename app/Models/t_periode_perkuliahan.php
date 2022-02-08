<?php

namespace App\Models;

class t_periode_perkuliahan extends SushiModel
{

    protected $primaryKey = 'id_prodi';

    public function getRows()
    {
        return GetDataFeeder('GetListPeriodePerkuliahan', self::$filter);
    }
}
