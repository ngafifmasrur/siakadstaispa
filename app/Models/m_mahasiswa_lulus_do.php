<?php

namespace App\Models;

class m_mahasiswa_lulus_do extends SushiModel
{
    protected $schema = [
        'id_registrasi_mahasiswa' => 'uuid',
        'id_mahasiswa' => 'uuid',
        'nim' => 'string',
        'nama_mahasiswa' => 'string',
        'id_prodi' => 'uuid',
        'nama_program_studi' => 'string',
        'angkatan' => 'integer',
        'id_jenis_keluar' => 'integer',
        'nama_jenis_keluar' => 'string',
        'tanggal_keluar' => 'date',
        'id_periode_keluar' => 'integer',
        'keterangan' => 'string',
        'nomor_sk_yudisium' => 'string',
        'tanggal_sk_yudisium' => 'date',
        'ipk' => 'float',
        'jalur_skripsi' => 'integer',
        'judul_skripsi' => 'string',
        'bulan_awal_bimbingan' => 'date',
        'bulan_akhir_bimbingan' => 'string',
        'id_dosen' => 'uuid',
        'nama_dosen' => 'string',
        'pembimbing_ke' => 'integer',
        'asal_ijazah' => 'integer',
    ];

    public function getRows()
    {
        return GetDataFeeder('GetDetailMahasiswaLulusDO', self::$filter);
    }
}
