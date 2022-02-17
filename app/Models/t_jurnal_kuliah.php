<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class t_jurnal_kuliah extends Model
{
    use HasFactory;

    protected $table = 't_jurnal_kuliah';
    protected $guarded = [];

    public function kelas()
    {
        return $this->belongsTo('App\Models\m_kelas_kuliah', 'id_kelas_kuliah', 'id_kelas_kuliah');
    }

    public function prodi()
    {
        return $this->belongsTo(m_program_studi::class, 'id_prodi', 'id_prodi');
    }

    public function absensi()
    {
        return $this->hasMany('App\Models\t_absensi_mahasiswa', 'id_jurnal_kuliah');
    }

    public function getHadir()
    {
        return $this->absensi->where('status', 'Hadir')->count();
    }

    public function getTidakHadir()
    {
        return $this->absensi->where('status', '!=','Hadir')->count();
    }

    public function getMHSTidakHadir()
    {
        return $this->absensi->where('status', '!=','Hadir');
    }
}
