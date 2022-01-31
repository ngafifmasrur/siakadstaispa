<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ref_negara extends Model
{
    use HasFactory, \Sushi\Sushi;

    protected $primaryKey = 'id_negara';
    public $incrementing = false;
    protected $keyType = 'string';

    public function getRows()
    {
        return GetDataFeeder('getNegara');
    }
}
