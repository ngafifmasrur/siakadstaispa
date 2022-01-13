<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class m_tahun_ajaran extends Model
{
    use HasFactory;

    protected $table = 'm_tahun_ajaran';
    protected $primaryKey = 'id_tahun_ajaran';
    protected $guarded = [];
}
