<?php

namespace Modules\Admission\Models;

use Illuminate\Database\Eloquent\Model;

class CostInformation extends Model
{
    /**
     * The table associated with the model.
     */
    protected $table = "cost_informations";

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name', 'detail', 'description'
    ];

}
