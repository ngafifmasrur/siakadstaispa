<?php

namespace App\Models;

class ref_jenis_pendaftaran extends SushiModel
{
    protected $primaryKey = 'id_jenis_daftar';

    public function getRows()
    {
        return GetDataFeeder('GetJenisPendaftaran');
    }
}
