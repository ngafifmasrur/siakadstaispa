<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ref_alat_transportasi extends Model
{
    use HasFactory;

    protected $table = 'ref_alat_transportasi';
    protected $guarded = [];
    protected $primaryKey = 'id_alat_transportasi';

}
