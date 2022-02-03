<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Sushi\Sushi;

class m_kelas_kuliah extends Model
{
    use HasFactory, Sushi;

    protected $primaryKey = 'id_kelas_kuliah';
    protected $guarded = [];
    public $incrementing = false;
    protected $keyType = 'string';
    
    public function getRows()
    {
        return GetDataFeeder('GetListKelasKuliah');
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
}
