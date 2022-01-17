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
