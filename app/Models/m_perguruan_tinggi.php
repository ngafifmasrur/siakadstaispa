<?php

namespace App\Models;


class m_perguruan_tinggi extends SushiModel
{
    protected $primaryKey = 'id_perguruan_tinggi';

    public function getRows()
    {
        return GetDataFeeder('GetProfilPT');
    }
}
