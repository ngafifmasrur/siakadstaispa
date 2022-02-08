<?php

namespace App\Models;

class t_riwayat_pendidikan_mahasiswa extends SushiModel
{
    protected $primaryKey = 'id_registrasi_mahasiswa';

    public static function getRows()
    {
        return GetDataFeeder('GetListRiwayatPendidikanMahasiswa', self::$filter);
    }

    public function prodi()
    {
        return $this->belongsTo('App\Models\m_program_studi', 'id_prodi');
    }

    public function periode()
    {
        return $this->belongsTo('App\Models\m_semester', 'id_periode_masuk');
    }

    public function jenis_daftar()
    {
        return $this->belongsTo('App\Models\ref_jenis_pendaftaran', 'id_jenis_daftar');
    }

    public function mahasiswa()
    {
        return $this->belongsTo('App\Models\m_mahasiswa', 'id_mahasiswa');
    }

    public static function byProdi()
    {
        return static::query()->where('id_prodi', auth()->user()->id_prodi);
    }
}
