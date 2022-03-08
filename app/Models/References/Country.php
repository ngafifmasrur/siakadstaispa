<?php

namespace App\Models\References;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $table = "ref_countries";
    
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'kd', 'name'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     */
    protected $hidden = [];

    /**
     * The attributes that define value is a instance of carbon.
     */
    protected $dates = [];

    /**
     * The attributes that define validation rules.
     */
    public static $rules = [
        'kd'                => 'required|string|unique:contries,kd',
        'name'              => 'required|string',
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [];
}
