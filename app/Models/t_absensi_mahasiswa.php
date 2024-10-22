<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class t_absensi_mahasiswa extends Model
{
    use HasFactory;

    
    protected $table = 't_absensi_mahasiswa';
    protected $guarded = [];

    public function mahasiswa()
    {
        return $this->belongsTo('App\Models\m_mahasiswa', 'id_mahasiswa');
    }
}
