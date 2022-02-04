<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Sushi\Sushi;

class t_detail_nilai_perkuliahan_kelas extends Model
{
    use HasFactory, Sushi;

    protected $guarded = [];
    public $incrementing = false;
    protected $keyType = 'string';

    public function getRows()
    {
        return GetDataFeeder('GetDetailNilaiPerkuliahanKelas');
    }
}
