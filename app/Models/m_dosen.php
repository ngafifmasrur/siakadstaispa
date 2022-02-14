<?php

namespace App\Models;
use App\Models\m_dosen_belum_nidn;

class m_dosen extends SushiModel
{
    protected $primaryKey = 'id_dosen';
    protected $schema = [
        'id_dosen' => 'uuid',
        'nama_dosen' => 'string',
        'nidn' => 'string',
        'nip' => 'string',
        'jenis_kelamin' => 'string',
        'id_agama' => 'integer',
        'tanggal_lahir' => 'date',
        'id_status_aktif' => 'boolean',
        'nama_status_aktif' => 'string'
    ];

    public function getRows()
    {
        $dosen_belum_nidn = m_dosen_belum_nidn::all()->toArray();
        $data = array_merge(GetDataFeeder('GetListDosen', self::$filter), $dosen_belum_nidn);
        return $data;
    }

    public static function count_total()
    {
        return count(GetDataFeeder('GetListDosen', self::$filter));
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_dosen');
    }

    public function hasUser()
    {
        $user = User::where('id_dosen', $this->id_dosen)->count();
        return $user > 0 ? true : false;
    }
}
