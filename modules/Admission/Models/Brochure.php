<?php

namespace Modules\Admission\Models;

use Illuminate\Database\Eloquent\Model;

class Brochure extends Model
{
    /**
     * The table associated with the model.
     */
    protected $table = "brochures";

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name', 'type', 'path_file', 'status'
    ];

}
