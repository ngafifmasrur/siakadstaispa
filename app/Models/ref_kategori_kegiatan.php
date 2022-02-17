<?php

namespace App\Models;

class ref_kategori_kegiatan extends SushiModel
{
    protected $primaryKey = 'id_kategori_kegiatan';
    protected $schema = [
        'id_kategori_kegiatan' => 'integer',
        'nama_kategori_kegiatan' => 'string',
    ];
    
    public function getRows()
    {
        return GetDataFeeder('GetKategoriKegiatan', self::$filter);
    }
}
