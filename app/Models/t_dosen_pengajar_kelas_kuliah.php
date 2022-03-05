<?php

namespace App\Models;
use App\Models\t_dosen_belum_nidn_pengajar_kelas_kuliah;

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
        $dosen_belum_nidn = t_dosen_belum_nidn_pengajar_kelas_kuliah::all()->toArray();
        $dosen_feeder = GetDataFeeder('GetDosenPengajarKelasKuliah', self::$filter);
        
        if($dosen_feeder != ""){
            $data = $data = array_merge($dosen_feeder, $dosen_belum_nidn);
        }else{
            $data = $dosen_belum_nidn;
        }
        
        return $data;
    }

    public function kelas_kuliah()
    {
        return $this->belongsTo(m_kelas_kuliah::class, 'id_kelas_kuliah');
    }
}
