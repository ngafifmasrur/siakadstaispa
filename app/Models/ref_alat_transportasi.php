<?php

namespace App\Models;

class ref_alat_transportasi extends SushiModel
{

    protected $primaryKey = 'id_alat_transportasi';
    protected $schema = [
        'id_alat_transportasi' => 'integer',
        'nama_alat_transportasi' => 'string',
    ];

    public function getRows()
    {
        return GetDataFeeder('GetAlatTransportasi');
    }
}
