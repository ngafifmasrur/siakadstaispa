<?php

namespace App\Models;

class t_matkul_kurikulum extends SushiModel
{
    public function getRows()
    {
        return GetDataFeeder('GetMatkulKurikulum', self::$filter);
    }
}
