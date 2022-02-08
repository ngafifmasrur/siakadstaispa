<?php

namespace App\Models;

class m_mahasiswa extends SushiModel
{
    protected $primaryKey = 'id_mahasiswa';
    protected $schema = [
        'nama_mahasiswa' => 'string',
        'jenis_kelamin' => 'string',
        'tanggal_lahir' => 'date',
        'id_perguruan_tinggi' => 'uuid',
        'id_mahasiswa' => 'uuid',
        'id_agama' => 'integer',
        'id_prodi' => 'uuid',
        'nama_program_studi' => 'string',
        'nama_status_mahasiswa' => 'string',
        'nim' => 'string',
        'id_periode' => 'integer',
        'nama_periode_masuk' => 'string',
        'id_registrasi_mahasiswa' => 'uuid',
    ];

    public function getRows()
    {
        return GetDataFeeder('GetListMahasiswa', self::$filter);
    }

    public static function count_total()
    {
        return GetDataFeeder('GetCountMahasiswa', self::$filter);
    }
    
    public function prodi()
    {
        return $this->belongsTo('App\Models\m_program_studi', 'id_prodi');
    }

    public function periode()
    {
        return $this->belongsTo('App\Models\m_semester', 'id_periode');
    }

    public function pt()
    {
        return $this->belongsTo('App\Models\m_perguruan_tinggi', 'id_perguruan_tinggi');
    }

    public function agama()
    {
        return $this->belongsTo('App\Models\ref_agama', 'id_agama');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_mahasiswa', 'id_mahasiswa');
    }

    public function hasUser()
    {
        $user = User::where('id_mahasiswa', $this->id_mahasiswa)->count();
        return $user > 0 ? true : false;
    }

    public function riwayat_pendidikan()
    {
        return $this->hasMany(t_riwayat_pendidikan::class, 'id_mahasiswa');
    }
}
