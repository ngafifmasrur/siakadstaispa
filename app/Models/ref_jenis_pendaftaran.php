<?php

namespace App\Models;

class ref_jenis_pendaftaran extends SushiModel
{
    protected $primaryKey = 'id_jenis_daftar';
    protected $schema = [
        'id_jenis_daftar' => 'string',
        'nama_jenis_daftar' => 'string',
        'untuk_daftar_sekolah' => 'boolean',
    ];

    public function getRows()
    {
        return GetDataFeeder('GetJenisPendaftaran');
    }
}
