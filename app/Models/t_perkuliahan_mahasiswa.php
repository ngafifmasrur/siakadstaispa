<?php

namespace App\Models;

class t_perkuliahan_mahasiswa extends SushiModel
{
    public function getRows()
    {
        return GetDataFeeder('GetListPerkuliahanMahasiswa', self::$filter);
    }
}
