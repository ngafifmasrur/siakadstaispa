<?php

namespace App\Models;

class t_matkul_kurikulum extends SushiModel
{

    protected $schema = [
        'id_kurikulum' => 'uuid',
        'nama_kurikulum' => 'string',
        'id_matkul' => 'uuid',
        'kode_mata_kuliah' => 'string',
        'nama_mata_kuliah' => 'string',
        'id_prodi' => 'uuid',
        'nama_program_studi' => 'string',
        'semester' => 'integer',
        'id_semester' => 'integer',
        'semester_mulai_berlaku' => 'string',
        'sks_mata_kuliah' => 'float',
        'sks_tatap_muka' => 'float',
        'sks_praktek' => 'float',
        'sks_praktek_lapangan' => 'float',
        'sks_simulasi' => 'float',
        'apakah_wajib' => 'boolean',
    ];
    
    public function getRows()
    {
        return GetDataFeeder('GetMatkulKurikulum', self::$filter);
    }
}

