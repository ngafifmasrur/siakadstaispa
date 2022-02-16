<?php

namespace App\Models;

class m_jenis_aktivitas extends SushiModel
{ 
    protected $primaryKey = 'id_jenis_aktivitas_mahasiswa';
    protected $schema = [
        'id_jenis_aktivitas_mahasiswa' => 'integer',
        'nama_jenis_aktivitas_mahasiswa' => 'string',
    ];

    public function getRows()
    {
        return GetDataFeeder('GetJenisAktivitasMahasiswa', self::$filter);
    }
}
