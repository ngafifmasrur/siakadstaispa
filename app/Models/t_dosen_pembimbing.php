<?php

namespace App\Models;

class t_dosen_pembimbing extends SushiModel
{
    protected $schema = [
        'id_aktivitas' => 'uuid',
        'judul' => 'string',
        'id_bimbing_mahasiswa' => 'uuid',
        'id_kategori_kegiatan' => 'integer',
        'nama_kategori_kegiatan' => 'string',
        'id_dosen' => 'uuid',
        'pembimbing_ke' => 'integer',
        'nama_dosen' => 'string',
    ];

    public function getRows()
    {
        return GetDataFeeder('GetMahasiswaBimbinganDosen', self::$filter);
    }
}