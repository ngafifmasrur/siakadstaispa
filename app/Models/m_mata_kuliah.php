<?php

namespace App\Models;

class m_mata_kuliah extends SushiModel
{

    protected $primaryKey = 'id_matkul';
    protected $appends = ['matkul_kode'];
    protected $schema = [
        'id_matkul' => 'uuid',
        'kode_mata_kuliah' => 'string',
        'nama_mata_kuliah' => 'string',
        'sks_mata_kuliah' => 'integer',
        'id_prodi' => 'uuid',
        'nama_program_studi' => 'string',
        'id_jenis_mata_kuliah' => 'string',
        'id_kelompok_mata_kuliah' => 'string',
        'semester' => 'integer',
    ];
    
    public function getRows()
    {
        return GetDataFeeder('GetListMataKuliah', self::$filter);
    }

    public function prodi()
    {
        return $this->belongsTo('App\Models\m_program_studi', 'id_prodi');
    }

    public function getMatkulKodeAttribute()
    {
        return $this->kode_mata_kuliah.' - '.$this->nama_mata_kuliah.'';

    }

    public static function byProdi()
    {
        return static::query()->where('id_prodi', auth()->user()->id_prodi);
    }

    public function jenis_matkul()
    {
        return $this->belongsTo(ref_jenis_mata_kuliah::class, 'id_jenis_mata_kuliah');
    }

    public function kelompok_matkul()
    {
        return $this->belongsTo(ref_kelompok_mata_kuliah::class, 'id_kelompok_mata_kuliah');
    }
}
