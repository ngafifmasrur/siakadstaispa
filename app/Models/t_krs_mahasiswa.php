<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class t_krs_mahasiswa extends Model
{
    use HasFactory;

    protected $table = 't_krs_mahasiswa';
    protected $guarded = [];

    public function mahasiswa()
    {
        return $this->belongsTo(t_riwayat_pendidikan_mahasiswa::class, 'id_registrasi_mahasiswa', 'id_registrasi_mahasiswa');
    }
}
