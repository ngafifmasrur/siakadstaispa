<?php

namespace App\Models;

class m_skala_nilai_prodi extends SushiModel
{
    protected $primaryKey = 'id_bobot_nilai';
    protected $schema = [
        'id_bobot_nilai' => 'uuid',
        'id_prodi' => 'uuid',
        'nama_program_studi' => 'string',
        'nilai_huruf' => 'string',
        'nilai_indeks' => 'float',
        'bobot_minimum' => 'float',
        'bobot_maksimum' => 'float',
        'tanggal_mulai_efektif' => 'date',
        'tanggal_akhir_efektif' => 'date'
    ];

    public function getRows()
    {
        return GetDataFeeder('GetListSkalaNilaiProdi', self::$filter);
    }

    public function prodi()
    {
        return $this->belongsTo('App\Models\m_program_studi', 'id_prodi');
    }
}