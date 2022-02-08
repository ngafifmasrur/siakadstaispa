<?php

namespace App\Models;

class m_semester extends SushiModel
{
    protected $primaryKey = 'id_semester';

    public function getRows()
    {
        return GetDataFeeder('GetSemester', self::$filter);
    }

    protected $schema = [
        'id_semester' => 'integer',
        'id_tahun_ajaran' => 'string',
        'nama_semester' => 'string',
        'semester' => 'integer',
        'a_periode_aktif' => 'boolean',
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
    ];
}
