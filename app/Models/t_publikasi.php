<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class t_publikasi extends Model
{
    use HasFactory;

    protected $table = 't_publikasi';
    protected $guarded = [];

    public function dosen()
	{
		return $this->belongsTo(m_dosen::class, 'id_dosen');
    }

    public function prodi()
	{
		return $this->belongsTo(m_program_studi::class, 'id_prodi');
    }

    public static function byDosen()
    {
        return static::query()->where('id_dosen', auth()->user()->dosen->id_dosen);
    }
}
