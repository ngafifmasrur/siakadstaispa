<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Sushi\Sushi;

class m_anggota_aktifitas_mahasiswa extends Model
{
    use HasFactory, Sushi;
    
    protected $primaryKey = 'id_anggota';
    protected $guarded = [];
    public $incrementing = false;
    protected $keyType = 'string';
    
    public function getRows()
    {
        return GetDataFeeder('GetListAnggotaAktivitasMahasiswa');
    }

    public function aktivitas()
    {
        return $this->belongsTo(m_aktivitas::class, 'id_aktivitas', 'id_aktivitas');
    }

    public function mahasiswa()
    {
        return $this->belongsTo('App\Models\m_mahasiswa', 'id_registrasi_mahasiswa', 'id_mahasiswa');
    }
}
