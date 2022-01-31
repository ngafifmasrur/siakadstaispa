<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Sushi\Sushi;

class m_perguruan_tinggi extends Model
{
    use HasFactory, Sushi;

    protected $primaryKey = 'id_perguruan_tinggi';
    public $incrementing = false;
    protected $keyType = 'string';

    public function getRows()
    {
        return GetDataFeeder('GetProfilPT');
    }
}
