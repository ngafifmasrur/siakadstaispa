<?php

namespace App\Models;

class ref_alat_transportasi extends SushiModel
{

    protected $primaryKey = 'id_alat_transportasi';

    public function getRows()
    {
        return GetDataFeeder('GetAlatRansportasi');
    }
}
