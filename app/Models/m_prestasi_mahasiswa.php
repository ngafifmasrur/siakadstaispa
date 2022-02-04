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
}
