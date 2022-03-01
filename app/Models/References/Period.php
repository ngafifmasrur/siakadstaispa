<?php

namespace App\Models\References;

use App\Scopes\OrderByIdDescScope;

use Illuminate\Database\Eloquent\Model;

class Period extends Model
{
    
    /**
     * The connection name for the model.
     */
    protected $connection = 'mysql_references';

    /**
     * The table associated with the model.
     */
    protected $table = "ref_periods";

    /**
     * Indicates if the model should be timestamped.
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name', 'year'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     */
    protected $hidden = [];

    /**
     * The attributes that define value is a foundation of carbon.
     */
    protected $dates = [];

    /**
     * The attributes that define validation rules.
     */
    public static $rules = [
        'name'              => 'required|string',
        'year'              => 'required|date:Y'
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [];

    /**
     * The "booting" method of the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new OrderByIdDescScope);
    }
}
