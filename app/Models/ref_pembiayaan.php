<?php

namespace App\Models;

class ref_pembiayaan extends SushiModel
{
    protected $primaryKey = 'id_pembiayaan';
    protected $schema = [
        'id_pembiayaan' => 'integer',
        'nama_pembiayaan' => 'string',
    ];

    public function getRows()
    {
        return GetDataFeeder('GetPembiayaan');
    }
}
