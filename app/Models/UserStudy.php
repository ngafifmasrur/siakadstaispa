<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\References\ProvinceRegencyDistrict;

class UserStudy extends Model
{
    /**
     * The table associated with the model.
     */
    protected $table = "user_studies";

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'grade_id', 'name', 'npsn', 'nss', 'from', 'to', 'district_id'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     */
    protected $hidden = [
        'user_id', 'grade_id', 'district_id'
    ];

    /**
     * The attributes that define value is a instance of carbon.
     */
    protected $dates = [
        'created_at', 'updated_at'
    ];

    /**
     * The accessors to append to the model's array form.
     */
    protected $appends = [
        'range'
    ];

    /**
     * The attributes that define validation rules.
     */
    public static $rules = [
        'grade_id'          => 'required|exists:grades,id',
        'name'              => 'required|string|max:191',
        'npsn'              => 'nullable|string|max:191',
        'nss'               => 'nullable|string|max:191',
        'from'              => 'nullable|date_format:Y',
        'to'                => 'nullable|date_format:Y',
        'district_id'       => 'required|exists:province_regency_districts,id',
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [];

    /**
     * Get regional attributes.
     */
    public function getRangeAttribute () {
        return $this->from.' - '.($this->to == date('Y') ? 'sekarang' : $this->to);
    }

    /**
     * This belongs to user.
     */
    public function user () {
        return $this->belongsTo(User::class);
    }

    /**
     * This belongs to grade.
     */
    public function grade () {
        return $this->belongsTo('App\Models\References\Grade', 'grade_id')->withDefault();
    }

    /**
     * This belongs to district.
     */
    public function district () {
        return $this->belongsTo(ProvinceRegencyDistrict::class)->withDefault();
    }

    /**
     * Get regional attributes.
     */
    public function getRegionalAttribute () {
        return isset($this->district_id) ? join(', ', [
            $this->district->name,
            $this->district->regency->name,
            $this->district->regency->province->name
        ]) : null;
    }
}
