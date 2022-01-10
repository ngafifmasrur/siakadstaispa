<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class m_kelas_kuliah extends Model
{
    use HasFactory;

    protected $table = 'm_kelas_kuliah';
    protected $guarded = [];

    public function prodi()
    {
        return $this->belongsTo('App\Models\m_program_studi', 'id_prodi');
    }

    // public function semester()
    // {
    //     return $this->belongsTo('App\Models\m_semester', 'id_semester');
    // }

    // public function mata_kuliah()
    // {
    //     return $this->belongsTo('App\Models\m_mata_kuliah', 'id_matkul');
    // }
}
