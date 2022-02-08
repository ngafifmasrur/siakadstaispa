<?php

namespace App\Models;

class t_substansi_mata_kuliah extends SushiModel
{
    protected $primaryKey = 'id_substansi';
    protected $schema = [
        'id_substansi' => 'uuid',
        'id_prodi' => 'uuid',
        'nama_program_studi' => 'string',
        'nama_substansi' => 'string',
        'sks_mata_kuliah' => 'integer',
        'sks_tatap_muka' => 'string',
        'sks_praktek' => 'integer',
        'sks_simulasi' => 'integer',
        'sks_praktek_lapangan' => 'integer',
        'id_jenis_substansi' => 'integer',
        'nama_jenis_substansi' => 'string',
    ];
    public function getRows()
    {
        return GetDataFeeder('GetListSubstansiKuliah', self::$filter);
    }
}
