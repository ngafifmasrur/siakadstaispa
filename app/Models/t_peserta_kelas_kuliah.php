<?php

namespace App\Models;

class t_peserta_kelas_kuliah extends SushiModel
{
    public function getRows()
    {
        return GetDataFeeder('GetPesertaKelasKuliah', self::$filter);
    }

    public function nilai()
    {
        return $this->belongsTo(t_detail_nilai_perkuliahan_kelas::class, 'id_kelas_kuliah', 'id_kelas_kuliah');
    }
}

