<?php

namespace App\Models;

class m_anggota_aktifitas_mahasiswa extends SushiModel
{
    protected $primaryKey = 'id_anggota';
    
    public function getRows()
    {
        return GetDataFeeder('GetListAnggotaAktivitasMahasiswa', self::$filter);
    }

    public function aktivitas()
    {
        return $this->belongsTo(m_aktivitas::class, 'id_aktivitas', 'id_aktivitas');
    }

    public function mahasiswa()
    {
        return $this->belongsTo('App\Models\m_mahasiswa', 'id_registrasi_mahasiswa', 'id_mahasiswa');
    }
}
