<?php

namespace App\Models;

class t_riwayat_nilai_mahasiswa extends SushiModel
{
    protected $schema = [
        'id_registrasi_mahasiswa' => 'uuid',
        'id_prodi' => 'uuid',
        'nama_program_studi' => 'string',
        'id_periode' => 'integer',
        'id_matkul' => 'uuid',
        'nama_mata_kuliah' => 'string',
        'id_kelas' => 'uuid',
        'nama_kelas_kuliah' => 'integer',
        'sks_kelas_kuliah' => 'float',
        'nilai_angka' => 'float',
        'nilai_indeks' => 'float',
        'nilai_huruf' => 'string',
        'nim' => 'string',
        'nama_mahasiswa' => 'string',
        'angkatan' => 'integer'
    ];

    public function getRows()
    {
        return GetDataFeeder('GetRiwayatNilaiMahasiswa', self::$filter);
    }

    public function matkul()
    {
        return $this->belongsTo(m_mata_kuliah::class, 'id_matkul', 'id_matkul');
    }
}
