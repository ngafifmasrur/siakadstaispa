<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class t_peserta_kelas_kuliah extends Model
{
    use HasFactory;

    protected $table = 't_peserta_kelas_kuliah';
    protected $guarded = [];

    public function kelas()
    {
        return $this->belongsTo('App\Models\m_kelas_kuliah', 'id_kelas_kuliah');
    }

    public function riwayat_pendidikan_mhs()
    {
        return $this->belongsTo('App\Models\t_riwayat_pendidikan_mahasiswa', 'id_registrasi_mahasiswa');
    }
}
