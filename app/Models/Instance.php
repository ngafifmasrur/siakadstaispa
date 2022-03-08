<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Instance extends Model
{
    

    /**
     * The table associated with the model.
     */
    protected $table = "insts";

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'short_name', 'name', 'long_name', 'header'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     */
    protected $hidden = [];

    /**
     * The attributes that define value is a instance of carbon.
     */
    protected $dates = [
        'created_at', 'updated_at'
    ];

    /**
     * The attributes that define validation rules.
     */
    public static $rules = [
        'short_name'        => 'string|max:255',
        'name'              => 'required|string',
        'long_name'         => 'string|max:255',
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [];

    /**
     * This has many admissions.
     */
    public function admissions () {
        return $this->hasManyThrough(Admission::class, Period::class);
    }

    /**
     * This has many conversions.
     */
    public function conversions () {
        return $this->hasMany(InstanceConversion::class, 'inst_id');
    }

    /**
     * Get config.
     */
    public function getConfig ($kd) {
        return $this->config()->where('kd', $kd)->first();
    }
}
