<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InstanceConfig extends Model
{  
    /**
     * The table associated with the model.
     */
    protected $table = "inst_config";

    /**
     * Indicates if the model should be timestamped.
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'inst_id', 'kd', 'cached', 'name', 'description', 'value'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     */
    protected $hidden = [
        'inst_id'
    ];

    /**
     * The attributes that define value is a instance of carbon.
     */
    protected $dates = [];

    /**
     * The attributes that define validation rules.
     */
    public static $rules = [];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [];

    /**
     * This belongs to inst.
     */
    public function instance () {
        return $this->belongsTo(Instance::class, 'inst_id')->withDefault();;
    }
}
