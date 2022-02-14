<?php

namespace App\Models;
use App\Models\t_penugasan_dosen_belum_nidn;

class t_penugasan_dosen extends SushiModel
{
    protected $primaryKey = 'id_registrasi_dosen';
    protected $schema = [
        'id_registrasi_dosen' => 'uuid',
        'id_dosen' => 'uuid',
        'nama_dosen' => 'string',
        'nidn' => 'string',
        'id_tahun_ajaran' => 'integer',
        'nama_tahun_ajaran' => 'string',
        'id_perguruan_tinggi' => 'uuid',
        'id_prodi' => 'uuid',
        'nama_program_studi' => 'string',
        'nomor_surat_tugas' => 'string',
        'tanggal_surat_tugas' => 'date',
        'mulai_surat_tugas' => 'date'
    ];
    
    public function getRows()
    {
        $dosen_belum_nidn = t_penugasan_dosen_belum_nidn::all()->toArray();
        $data = array_merge(GetDataFeeder('GetListPenugasanDosen', self::$filter), $dosen_belum_nidn);
        return $data;
    }
}
