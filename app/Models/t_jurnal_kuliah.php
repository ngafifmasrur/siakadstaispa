<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class t_jurnal_kuliah extends Model
{
    use HasFactory;

    protected $table = 't_jurnal_kuliah';
    protected $guarded = [];

    public function jadwal()
    {
        return $this->belongsTo('App\Models\m_jadwal', 'id_jadwal');
    }

    public function prodi()
    {
        return $this->belongsTo('App\Models\m_program_studi', 'id_prodi');
    }
}
