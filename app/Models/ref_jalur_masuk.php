<?php

namespace App\Models;

class ref_jalur_masuk extends SushiModel
{
    protected $primaryKey = 'id_jalur_masuk';
    protected $schema = [
        'id_jalur_masuk' => 'integer',
        'nama_jalur_masuk' => 'string',
    ];

    public function getRows()
    {
        return GetDataFeeder('GetJalurMasuk');
    }
}
