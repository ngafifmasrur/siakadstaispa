<?php

namespace App\Models;
use App\Models\m_jadwal;

class m_kelas_kuliah extends SushiModel
{

    protected $primaryKey = 'id_kelas_kuliah';
    protected $schema = [
        'id_kelas_kuliah' => 'uuid',
        'id_prodi' => 'uuid',
        'nama_program_studi' => 'string',
        'id_semester' => 'integer',
        'nama_semester' => 'string',
        'id_matkul' => 'uuid',
        'kode_mata_kuliah' => 'string',
        'nama_mata_kuliah' => 'string',
        'nama_kelas_kuliah' => 'string',
        'bahasan' => 'string',
        'lingkup' => 'integer',
        'mode' => 'string',
        'tanggal_mulai_efektif' => 'date',
        'tanggal_akhir_efektif' => 'date',
        'kapasitas' => 'integer',
        'tanggal_tutup_daftar' => 'date',
        'prodi_penyelenggara' => 'uuid',
        'perguruan_tinggi_penyelenggara' => 'uuid',

    ];

    public function getRows()
    {
        return GetDataFeeder('GetListKelasKuliah', self::$filter);
    }

    public function prodi()
    {
        return $this->belongsTo('App\Models\m_program_studi', 'id_prodi');
    }

    public function semester()
    {
        return $this->belongsTo('App\Models\m_semester', 'id_semester');
    }

    public function mata_kuliah()
    {
        return $this->belongsTo('App\Models\m_mata_kuliah', 'id_matkul');
    }

    public static function byProdi()
    {
        return static::query()->where('id_prodi', auth()->user()->id_prodi);
    }

    public function jadwal()
    {
        return $this->belongsTo('App\Models\m_jadwal', 'id_kelas_kuliah');
    }

    public function dosen()
    {
        return $this->hasMany(t_dosen_pengajar_kelas_kuliah::class, 'id_kelas_kuliah', 'id_kelas_kuliah');
    }

    public function mahasiswa()
    {
        return $this->hasMany(t_peserta_kelas_kuliah::class, 'id_kelas_kuliah');
    }
}
