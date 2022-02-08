<?php

namespace App\Models;

class t_riwayat_pendidikan_mahasiswa extends SushiModel
{
    protected $primaryKey = 'id_registrasi_mahasiswa';
    protected $schema = [
        'id_registrasi_mahasiswa' => 'uuid',
        'id_mahasiswa' => 'uuid',
        'nim' => 'string',
        'nama_mahasiswa' => 'string',
        'id_jenis_daftar' => 'integer',
        'nama_jenis_daftar' => 'string',
        'id_jalur_daftar' => 'integer',
        'id_periode_masuk' => 'integer',
        'nama_periode_masuk' => 'string',
        'tanggal_daftar' => 'date',
        'id_jenis_keluar' => 'integer',
        'keterangan_keluar' => 'string',
        'id_perguruan_tinggi' => 'uuid',
        'nama_perguruan_tinggi' => 'string',
        'id_prodi' => 'uuid',
        'nama_program_studi' => 'string',
        'sks_diakui' => 'integer',
        'id_perguruan_tinggi_asal' => 'uuid',
        'nama_perguruan_tinggi_asal' => 'string',
        'id_prodi_asal' => 'uuid',
        'nama_program_studi_asal' => 'string',
        'jenis_kelamin' => 'string',
        'tanggal_lahir' => 'date',
        'nama_ibu_kandung' => 'string',
        'nama_ibu' => 'string',
        'id_pembiayaan' => 'integer',
        'nama_pembiayaan_awal' => 'string',
        'biaya_masuk' => 'float',
        'id_bidang_minat' => 'integer',
        'nm_bidang_minat' => 'integer'
    ];

    public function getRows()
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
