<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class t_kuesioner extends Model
{
    use HasFactory;
    protected $table = 't_kuesioner';
    protected $fillable = ['id','kuesioner_id','dosen_id','mahasiswa_id','skor','matkul_id'];

    public function mata_kuliah()
    {
        return $this->belongsTo(m_mata_kuliah::class, 'matkul_id');
    }
    public function dosen()
    {
        return $this->belongsTo(m_dosen::class, 'dosen_id');
    }
    public function mahasiswa()
    {
        return $this->belongsTo(m_mahasiswa::class, 'mahasiswa_id');
    }
}
