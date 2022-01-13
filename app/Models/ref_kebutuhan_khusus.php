<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ref_kebutuhan_khusus extends Model
{
    use HasFactory;

    protected $table = 'ref_kebutuhan_khusus';
    protected $guarded = [];
    protected $primaryKey = 'id_kebutuhan_khusus';

}
