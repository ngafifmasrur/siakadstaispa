<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Sushi\Sushi;

class m_semester extends Model
{
    use HasFactory, Sushi;

    // protected $table = 'm_semester';
    protected $primaryKey = 'id_semester';
    protected $guarded = [];

    public function getRows()
    {
        return GetDataFeeder('GetSemester');
    }
}
