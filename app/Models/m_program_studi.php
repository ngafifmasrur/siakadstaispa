<?php

namespace App\Models;

class m_program_studi extends SushiModel
{
    protected $primaryKey = 'id_prodi';
    protected $schema = [
        'id_prodi' => 'uuid',
        'kode_program_studi' => 'string',
        'nama_program_studi' => 'string',
        'status' => 'string',
        'id_jenjang_pendidikan' => 'integer',
        'nama_jenjang_pendidikan' => 'string',
    ];

    public function getRows()
    {
        return GetDataFeeder('GetProdi', self::$filter);
    }
}
