<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ref_agama extends Model
{
    use HasFactory;

    protected $table = 'ref_agama';
    protected $guarded = [];
    protected $primaryKey = 'id_agama';
}
