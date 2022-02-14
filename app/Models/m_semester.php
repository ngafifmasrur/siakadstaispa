<?php

namespace App\Models;

class m_semester extends SushiModel
{
    protected $primaryKey = 'id_semester';
    protected $schema = [
        'id_semester' => 'integer',
        'id_tahun_ajaran' => 'integer',
        'nama_semester' => 'string',
        'semester' => 'integer',
        'a_periode_aktif' => 'boolean',
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
    ];
    
    public function getRows()
    {
        return GetDataFeeder('GetSemester', self::$filter);
    }

    public function tahun_ajaran()
    {
        return $this->belongsTo(m_tahun_ajaran::class, 'id_tahun_ajaran');
    }
}
