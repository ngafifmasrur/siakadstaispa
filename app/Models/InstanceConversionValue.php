<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InstanceConversionValue extends Model
{  
    /**
     * The table associated with the model.
     */
    protected $table = "inst_conversion_values";

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'conversion_id', 'min', 'max', 'alpha', 'result'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     */
    protected $hidden = [
        'conversion_id'
    ];

    /**
     * The attributes that define value is a instance of carbon.
     */
    protected $dates = [
        'created_at', 'updated_at'
    ];

    /**
     * The attributes that define validation rules.
     */
    public static $rules = [];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [
            'min'   => 'float',
            'max'   => 'float',
            'result'   => 'float',
        ];
}
