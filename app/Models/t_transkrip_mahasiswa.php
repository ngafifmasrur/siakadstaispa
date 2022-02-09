<?php

namespace App\Models;

class t_transkrip_mahasiswa extends SushiModel
{
    protected $schema = [
        'id_registrasi_mahasiswa' => 'uuid',
        'id_matkul' => 'uuid',
        'id_kelas_kuliah' => 'uuid',
        'id_nilai_transfer' => 'uuid',
        'smt_diambil' => 'integer',
        'kode_mata_kuliah' => 'string',
        'nama_mata_kuliah' => 'string',
        'sks_mata_kuliah' => 'float',
        'nilai_angka' => 'float',
        'nilai_indeks' => 'float',
        'nilai_huruf' => 'string',
    ];

    public function getRows()
    {
        return GetDataFeeder('GetTranskripMahasiswa', self::$filter);
    }
}
