<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Sushi\Sushi;

class t_dosen_pengajar_kelas_kuliah extends Model
{
    use HasFactory, Sushi;

    protected $primaryKey = 'id_aktivitas_mengajar';
    protected $guarded = [];
    public $incrementing = false;
    protected $keyType = 'string';

    public function getRows()
    {
        return GetDataFeeder('GetDosenPengajarKelasKuliah');
    }
}
