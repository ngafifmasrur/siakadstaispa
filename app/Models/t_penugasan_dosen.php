<?php

namespace App\Models;

class t_penugasan_dosen extends SushiModel
{
    protected $primaryKey = 'id_registrasi_dosen';

    public function getRows()
    {
        return GetDataFeeder('GetListPenugasanDosen', self::$filter);
    }
}
