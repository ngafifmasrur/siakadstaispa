<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Sushi\Sushi;

class t_periode_perkuliahan extends Model
{
    use HasFactory, Sushi;

    protected $primaryKey = 'id_prodi';
    protected $guarded = [];
    public $incrementing = false;
    protected $keyType = 'string';

    public function getRows()
    {
        return GetDataFeeder('GetListPeriodePerkuliahan');
    }
}
