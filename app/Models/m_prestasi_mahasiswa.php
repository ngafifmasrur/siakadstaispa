<?php

namespace App\Models;

class m_prestasi_mahasiswa extends SushiModel
{
    
    protected $primaryKey = 'id_prestasi';
    
    public function getRows()
    {
        return GetDataFeeder('GetListPrestasiMahasiswa', self::$filter);
    }

    public function jenis_prestasi()
    {
        return $this->belongsTo(m_jenis_prestasi::class, 'id_jenis_prestasi', 'id_jenis_prestasi');
    }

    public function tingkat_prestasi()
    {
        return $this->belongsTo(m_tingkat_prestasi::class, 'id_tingkat_prestasi', 'id_tingkat_prestasi');
    }
}
