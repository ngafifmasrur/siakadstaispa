<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class t_semester_mahasiswa extends Model
{
    use HasFactory;

    protected $table = 't_semester_mahasiswa';
    protected $guarded = [];

    public function prodi()
    {
      return $this->belongsTo('App\Models\m_program_studi', 'id_prodi');
    }

    public function mahasiswa()
    {
        return $this->belongsTo('App\Models\m_mahasiswa', 'id_mahasiswa');
    }

    public function tahun_ajaran()
    {
        return $this->belongsTo('App\Models\m_tahun_ajaran', 'id_tahun_ajaran');
    }

    public function detail_semester()
    {
        return $this->belongsTo('App\Models\m_semester', 'id_semester');
    }

    public static function byProdi()
    {
        return static::query()->where('id_prodi', auth()->user()->id_prodi);
    }
}
