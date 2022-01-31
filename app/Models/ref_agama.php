<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Sushi\Sushi;

class ref_agama extends Model
{
    use HasFactory, Sushi;

    // protected $table = 'ref_agama';
    protected $guarded = [];
    protected $primaryKey = 'id_agama';

    public function getRows()
    {
        return GetDataFeeder('GetAgama');
    }
}
