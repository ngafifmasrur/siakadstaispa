<?php

namespace App\Models;
use App\Models\m_jadwal;

class m_kelas_kuliah extends SushiModel
{

    protected $primaryKey = 'id_kelas_kuliah';
    protected $appends = ['hari', 'jam_mulai', 'jam_akhir', 'ruangan'];

    public function getRows()
    {
        $data = GetDataFeeder('GetDetailKelasKuliah', self::$filter);
        foreach($data as $key => $item) {
            $data[$key]['hari'] = $this->jadwal('hari');
            $data[$key]['ruangan'] = $this->jadwal('ruang');
            $data[$key]['jam_mulai'] = $this->jadwal('jam_mulai');
            $data[$key]['jam_akhir'] = $this->jadwal('jam_akhir');
        }

        return $data;
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

    public function getRuanganAttribute()
    {
        return $this->jadwal('ruang');
    }

    public function getJamMulaiAttribute()
    {
        return $this->jadwal('jam_mulai');
    }

    public function getJamAkhirAttribute()
    {
        return $this->jadwal('jam_akhir');
    }

    public function getHariAttribute()
    {
        return $this->jadwal('hari');
    }

    public function jadwal($value)
    {
        if($value == 'ruang') {
            $result = m_jadwal::where('id_kelas_kuliah', $this->id_kelas_kuliah)->first()->ruangan->nama_ruangan ?? NULL;
        } else {
            $result = m_jadwal::where('id_kelas_kuliah', $this->id_kelas_kuliah)->first()->$value ?? NULL;
        }
        return $result;
    }

    public function dosen()
    {
        return $this->hasMany(t_dosen_pengajar_kelas_kuliah::class, 'id_kelas_kuliah');
    }

    public function mahasiswa()
    {
        return $this->hasMany(t_peserta_kelas_kuliah::class, 'id_kelas_kuliah');
    }
}
