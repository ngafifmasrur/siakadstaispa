<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ref_jenjang_pendidikan extends Model
{
    use HasFactory;

    protected $table = 'ref_jenjang_pendidikan';
    protected $guarded = [];
    protected $primaryKey = 'id_jenjang_didik';
}
