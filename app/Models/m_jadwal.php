<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class m_jadwal extends Model
{
    use HasFactory;
    public $tahun_ajaran;

    protected $table = 'm_jadwal';
    protected $guarded = [];

    public function dosen()
	  {
		return $this->belongsTo('App\Models\m_dosen', 'id_dosen');
    }

    public function matkul()
	  {
		return $this->belongsTo('App\Models\m_mata_kuliah_aktif', 'id_matkul_aktif');
    }

    public function prodi()
	  {
		return $this->belongsTo('App\Models\m_program_studi', 'id_prodi');
    }

    public function kelas()
	  {
		return $this->belongsTo('App\Models\m_kelas_kuliah', 'id_kelas');
    }

    public function ruangan()
	  {
		return $this->belongsTo('App\Models\m_ruang_kelas', 'id_ruang');
    }
    
}
