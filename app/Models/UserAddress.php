<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    /**
     * The table associated with the model.
     */
    protected $table = "user_address";

    /**
     * The primary key for the model.
     */
    protected $primaryKey = 'user_id';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'address', 'rt', 'rw', 'village', 'district_id', 'postal'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     */
    protected $hidden = [
        'user_id', 'district_id'
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
    public static $rules = [
        'address'           => 'required|string|max:191',
        'rt'                => 'nullable|string|max:191',
        'rw'                => 'nullable|string|max:191',
        'village'           => 'nullable|string|max:191',
        'district_id'       => 'required|exists:references.province_regency_districts,id',
        'postal'            => 'required|string',
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [];

    /**
     * Get branch attributes.
     */
    public function getBranchAttribute () {
        return join(', ', array_filter([
            $this->address,
            isset($this->rt) ? ('RT '.$this->rt) : null,
            isset($this->rw) ? ('RW '.$this->rw) : null,
            $this->village
        ]));
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

    /**
     * Get full address attributes.
     */
    public function getFullAttribute () {
        return join(', ', array_filter([
            $this->address,
            isset($this->rt) ? ('RT '.$this->rt) : null,
            isset($this->rw) ? ('RW '.$this->rw) : null,
            $this->village,
            $this->regional,
            $this->postal
        ]));
    }

    /**
     * This belongs to user.
     */
    public function user () {
        return $this->belongsTo(User::class);
    }

    /**
     * This belongs to district.
     */
    public function district () {
        return $this->belongsTo('\App\Models\References\ProvinceRegencyDistrict')->withDefault();
    }
}
