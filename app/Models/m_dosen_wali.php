<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class m_dosen_wali extends Model
{
    use HasFactory;

    protected $table = 'm_dosen_wali';
    protected $guarded = [];

    public function dosen()
    {
        return $this->belongsTo(m_dosen::class, 'id_dosen');
    }

    public function mahasiswa()
    {
        return $this->hasMany(t_dosen_wali_mahasiswa::class, 'id_dosen', 'id_dosen');
    }
}