<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class t_krs extends Model
{
    use HasFactory;

    protected $table = 't_krs';
    protected $guarded = [];

    public function jadwal()
    {
        return $this->belongsTo('App\Models\m_jadwal', 'id_jadwal');
    }

    public function mahasiswa()
    {
        return $this->belongsTo(m_mahasiswa::class, 'nim', 'nim');
    }

    public static function byProdi()
    {
        return static::query()->whereHas('jadwal', function($q){
            $q->where('id_prodi', auth()->user()->id_prodi);
        });
    }
}
