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

	public function kelas()
	{
		return $this->belongsTo('App\Models\m_kelas_kuliah', 'id_kelas_kuliah');
	}

	public function ruangan()
	{
		return $this->belongsTo('App\Models\m_ruang_kelas', 'id_ruang');
	}

	public function krs()
	{
		return $this->hasMany('App\Models\t_krs', 'id_jadwal', 'id');
	}

	public function jurnal_kuliah()
	{
		return $this->hasMany('App\Models\t_jurnal_kuliah', 'id_jadwal', 'id');
	  }
	  
	  
	public static function byProdi()
	{
		return static::query()->where('id_prodi', auth()->user()->id_prodi);
	}
}
