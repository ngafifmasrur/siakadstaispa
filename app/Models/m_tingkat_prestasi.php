<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Sushi\Sushi;

class m_tingkat_prestasi extends Model
{
    use HasFactory, Sushi;

    
    protected $primaryKey = 'id_tingkat_prestasi';
    protected $guarded = [];
    public $incrementing = false;
    protected $keyType = 'string';
    
    public function getRows()
    {
        return GetDataFeeder('GetTingkatPrestasi');
    }
}
