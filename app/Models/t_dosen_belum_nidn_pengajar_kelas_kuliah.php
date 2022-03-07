<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class t_dosen_belum_nidn_pengajar_kelas_kuliah extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_aktivitas_mengajar';
    protected $schema = [
        'id_aktivitas_mengajar' => 'uuid',
        'id_registrasi_dosen' => 'uuid',
        'id_dosen' => 'uuid',
        'nidn' => 'string',
        'nama_dosen' => 'string',
        'id_kelas_kuliah' => 'uuid',
        'id_substansi' => 'integer',
        'sks_substansi_total' => 'integer',
        'rencana_minggu_pertemuan' => 'integer',
        'realisasi_minggu_pertemuan' => 'integer',
        'id_jenis_evaluasi' => 'integer',
        'nama_jenis_evaluasi' => 'string',
        'id_prodi' => 'uuid',
        'id_semester' => 'integer',
    ];
    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = "t_dosen_belum_nidn_pengajar_kelas_kuliah";
    protected $guarded = [];
    protected $hidden = ['created_at', 'updated_at','id_prodi','id_semester'];
    public $timestamps = false;
}
