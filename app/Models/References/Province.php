<?php

namespace App\Models\References;

use App\Scopes\OrderByNameScope;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $table = "ref_provinces";

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name'
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
        'name'              => 'required|string'
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

        static::addGlobalScope(new OrderByNameScope);
    }

    /**
     * This has many regencies.
     */
    public function regencies () {
        return $this->hasMany(ProvinceRegency::class);
    }

}
