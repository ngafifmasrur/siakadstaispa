<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Sushi\Sushi;

class t_penugasan_dosen extends Model
{
    use HasFactory, Sushi;

    protected $primaryKey = 'id_registrasi_dosen';
    protected $guarded = [];
    public $incrementing = false;
    protected $keyType = 'string';

    public function getRows()
    {
        return GetDataFeeder('GetListPenugasanDosen');
    }
}
