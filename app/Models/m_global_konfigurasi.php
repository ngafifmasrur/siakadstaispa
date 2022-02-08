<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class m_global_konfigurasi extends Model
{
    use HasFactory;
    protected $table = 'm_global_konfigurasi';
    protected $guarded = [];

    public function semester_aktif()
    {
        return $this->belongsTo('App\Models\m_semester', 'id_semester_aktif');
    }

    public function semester_nilai()
    {
        return $this->belongsTo('App\Models\m_semester', 'id_semester_nilai');
    }

    public function semester_krs()
    {
        return $this->belongsTo('App\Models\m_semester', 'id_semester_krs');
    }

    public function semester_tracer()
    {
        return $this->belongsTo('App\Models\m_semester', 'id_semester_tracer_study');
    }

}
