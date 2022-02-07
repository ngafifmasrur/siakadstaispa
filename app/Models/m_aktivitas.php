<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Sushi\Sushi;

class m_aktivitas extends Model
{
    use HasFactory, Sushi;
    
    protected $primaryKey = 'id_aktivitas';
    protected $guarded = [];
    public $incrementing = false;
    protected $keyType = 'string';
    
    public function getRows()
    {
        return GetDataFeeder('GetListAktivitasMahasiswa');
    }

    public function jenis_aktivitas()
    {
        return $this->belongsTo(m_jenis_aktivitas::class, 'id_jenis_aktivitas', 'id_jenis_aktivitas_mahasiswa');
    }

    public function semester()
    {
        return $this->belongsTo('App\Models\m_semester', 'id_semester', 'id_semester');
    }

    public function prodi()
    {
        return $this->belongsTo(m_program_studi::class, 'id_prodi');
    }

    public function anggota()
    {
        return $this->belongsTo(m_anggota_aktifitas_mahasiswa::class, 'id_aktivitas', 'id_aktivitas');
    }
}
