<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Sushi\Sushi;

class m_prestasi_mahasiswa extends Model
{
    use HasFactory, Sushi;
    
    protected $primaryKey = 'id_prestasi';
    protected $guarded = [];
    public $incrementing = false;
    protected $keyType = 'string';
    
    public function getRows()
    {
        return GetDataFeeder('GetListPrestasiMahasiswa');
    }

    public function jenis_prestasi()
    {
        return $this->belongsTo(m_jenis_prestasi::class, 'id_jenis_prestasi', 'id_jenis_prestasi');
    }

    public function tingkat_prestasi()
    {
        return $this->belongsTo(m_tingkat_prestasi::class, 'id_tingkat_prestasi', 'id_tingkat_prestasi');
    }
}
