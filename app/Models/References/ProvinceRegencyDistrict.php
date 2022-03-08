<?php

namespace App\Models\References;

use App\Scopes\OrderByNameScope;
use Illuminate\Database\Eloquent\Model;

class ProvinceRegencyDistrict extends Model
{
    protected $table = "ref_province_regency_districts";

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'regency_id', 'name'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     */
    protected $hidden = [
        'regency_id'
    ];

    /**
     * The attributes that define value is a instance of carbon.
     */
    protected $dates = [];

    /**
     * The attributes that define validation rules.
     */
    public static $rules = [
        'regency_id'        => 'required|integer|exists:province_regencies,id',
        'name'              => 'required|string'
    ];

    /**
    * The accessors to append to the model's array form.
    *
    * @var array
    */
    protected $appends = [
        'regional'
    ];

    /**
     * The "booting" method of the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new OrderByNameScope);
    }

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [];

    /**
     * This belongs to regency.
     */
    public function regency () {
        return $this->belongsTo(ProvinceRegency::class)->withDefault();
    }

    /**
     * Get regional attributes.
     */
    public function getRegionalAttribute () {
        return join(', ', [$this->name, $this->regency->name, $this->regency->province->name ]);
    }
}
