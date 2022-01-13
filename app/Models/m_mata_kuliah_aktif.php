<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class m_mata_kuliah_aktif extends Model
{
    use HasFactory;

    protected $table = 'm_mata_kuliah_aktif';
    protected $guarded = [];
    // // protected $appends = ['matkul_semester'];

    public function matkul()
	  {
		return $this->belongsTo('App\Models\m_mata_kuliah', 'id_matkul');
    }
    
    public function detail_semester()
	  {
		return $this->belongsTo('App\Models\m_semester', 'id_semester');
    }
    
    // public function getMatkulSemesterAttribute()
    // {
    //     return $this->matkul->nama_mata_kuliah.' ('.$this->semester->nama_semester.')';

    // }
}
