<?php

namespace App\Models;

class m_kurikulum extends SushiModel
{
    protected $primaryKey = 'id_kurikulum';
    protected $schema = [
        'id_kurikulum' => 'uuid',
        'nama_kurikulum' => 'string',
        'id_prodi' => 'uuid',
        'nama_program_studi' => 'string',
        'id_semester' => 'integer',
        'semester_mulai_berlaku' => 'string',
        'jumlah_sks_lulus' => 'integer',
        'jumlah_sks_wajib' => 'integer',
        'jumlah_sks_pilihan' => 'integer',
        'jumlah_sks_mata_kuliah_wajib' => 'integer',
        'jumlah_sks_mata_kuliah_pilihan' => 'integer',
    ];

    public function getRows()
    {
        return GetDataFeeder('GetListKurikulum', self::$filter);
    }

    public function prodi()
    {
        return $this->belongsTo('App\Models\m_program_studi', 'id_prodi');
    }

    public function semester()
    {
        return $this->belongsTo('App\Models\m_semester', 'id_semester');
    }
    
    public static function byProdi()
    {
        return static::query()->where('id_prodi', auth()->user()->id_prodi);
    }

}
