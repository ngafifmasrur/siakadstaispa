<?php

namespace App\Models;

class m_jenis_aktivitas extends SushiModel
{ 
    protected $primaryKey = 'id_jenis_aktivitas_mahasiswa';
    
    public function getRows()
    {
        return GetDataFeeder('GetJenisAktivitasMahasiswa', self::$filter);
    }
}
