<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Sushi\Sushi;

class t_riwayat_pendidikan_mahasiswa extends Model
{
    use HasFactory, Sushi;

    protected $primaryKey = 'id_registrasi_mahasiswa';
    protected $guarded = [];
    public $incrementing = false;
    protected $keyType = 'string';

    public function getRows()
    {
        return GetDataFeeder('GetListRiwayatPendidikanMahasiswa');
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
