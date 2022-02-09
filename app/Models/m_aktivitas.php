<?php

namespace App\Models;

class m_aktivitas extends SushiModel
{
    
    protected $primaryKey = 'id_aktivitas';
    protected $schema = [
        'id_aktivitas' => 'uuid',
        'jenis_anggota' => 'integer',
        'nama_jenis_anggota' => 'string',
        'id_jenis_aktivitas' => 'integer',
        'id_prodi' => 'uuid',
        'nama_prodi' => 'string',
        'id_semester' => 'uuid',
        'nama_semester' => 'string',
        'judul' => 'string',
        'keterangan' => 'string',
        'lokasi' => 'string',
        'sk_tugas' => 'string',
        'tanggal_sk_tugas' => 'date',
    ];

    public function getRows()
    {
        return GetDataFeeder('GetListAktivitasMahasiswa', self::$filter);
    }

    public function jenis_aktivitas()
    {
        return $this->belongsTo(m_jenis_aktivitas::class, 'id_jenis_aktivitas', 'id_jenis_aktivitas_mahasiswa');
    }

    public function semester()
    {
        return $this->belongsTo('App\Models\m_semester', 'id_semester', 'id_semester');
    }

    public function prodi()
    {
        return $this->belongsTo(m_program_studi::class, 'id_prodi');
    }

    public function anggota()
    {
        return $this->belongsTo(m_anggota_aktifitas_mahasiswa::class, 'id_aktivitas', 'id_aktivitas');
    }
}
