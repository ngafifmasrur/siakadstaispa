<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Sushi\Sushi;

class m_program_studi extends Model
{
    use HasFactory, Sushi;

    // protected $table = 'm_prodi';
    // protected $guarded = [];

    protected $primaryKey = 'id_prodi';
    public $incrementing = false;
    protected $keyType = 'string';

    public function getRows()
    {
        return GetDataFeeder('GetProdi');
    }
}
