<?php

namespace App\Models;
use App\Models\m_kelas_kuliah;

class t_dosen_pengajar_kelas_kuliah extends SushiModel
{
    protected $primaryKey = 'id_aktivitas_mengajar';
    protected $schema = [
        'id_aktivitas_mengajar' => 'uuid',
        'id_registrasi_dosen' => 'uuid',
        'id_dosen' => 'uuid',
        'nidn' => 'string',
        'nama_dosen' => 'string',
        'id_kelas_kuliah' => 'uuid',
        'id_substansi' => 'integer',
        'sks_substansi_total' => 'integer',
        'rencana_minggu_pertemuan' => 'integer',
        'realisasi_minggu_pertemuan' => 'integer',
        'id_jenis_evaluasi' => 'integer',
        'nama_jenis_evaluasi' => 'string',
        'id_prodi' => 'uuid',
        'id_semester' => 'integer',
    ];


    public function getRows()
    {
        return GetDataFeeder('GetDosenPengajarKelasKuliah', self::$filter);
    }

    public function kelas_kuliah()
    {
        return $this->belongsTo(m_kelas_kuliah::class, 'id_kelas_kuliah');
    }
}
