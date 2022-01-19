<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class m_mata_kuliah extends Model
{
    use HasFactory;

    protected $table = 'm_mata_kuliah';
    protected $primaryKey = 'id_matkul';
    protected $guarded = [];
    public $incrementing = false;
    protected $keyType = 'string';
    protected $appends = ['matkul_kode'];

    public function prodi()
    {
        return $this->belongsTo('App\Models\m_program_studi', 'id_prodi');
    }

    public function getMatkulKodeAttribute()
    {
        return $this->kode_mata_kuliah.' - '.$this->nama_mata_kuliah.'';

    }

    
    public static function byProdi()
    {
        return static::query()->where('id_prodi', auth()->user()->id_prodi);
    }
}
