<?php

namespace App\Models;

class m_tahun_ajaran extends SushiModel
{
    protected $primaryKey = 'id_tahun_ajaran';
    protected $schema = [
        'id_tahun_ajaran' => 'integer',
        'nama_tahun_ajaran' => 'string',
        'a_periode_aktif' => 'boolean',
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date'
    ];

    public function getRows()
    {
        return GetDataFeeder('GetTahunAjaran', self::$filter);
    }
}
