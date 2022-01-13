<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ref_jenis_tinggal extends Model
{
    use HasFactory;

    protected $table = 'ref_jenis_tinggal';
    protected $guarded = [];
    protected $primaryKey = 'id_jenis_tinggal';

}
