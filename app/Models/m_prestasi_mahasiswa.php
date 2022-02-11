<?php

namespace App\Models;

class m_prestasi_mahasiswa extends SushiModel
{
    
    protected $primaryKey = 'id_prestasi';
    protected $schema = [
        'id_prestasi' => 'uuid',
        'id_mahasiswa' => 'uuid',
        'nama_mahasiswa' => 'string',
        'id_jenis_prestasi' => 'integer',
        'nama_jenis_prestasi' => 'string',
        'id_tingkat_prestasi' => 'integer',
        'nama_tingkat_prestasi' => 'string',
        'nama_prestasi' => 'string',
        'tahun_prestasi' => 'integer',
        'penyelenggara' => 'string',
        'peringkat' => 'string'
    ];

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
