<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserFoster extends Model
{
    /**
     * The table associated with the model.
     */
    protected $table = "user_foster";

    /**
     * The primary key for the model.
     */
    protected $primaryKey = 'user_id';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name', 'pob', 'dob', 'nik', 'ktp', 'is_dead', 'employment_id', 'grade_id', 'salary_id', 'address', 'rt', 'rw', 'village', 'district_id', 'postal', 'biological'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     */
    protected $hidden = [
        'employment_id', 'grade_id', 'salary_id', 'district_id'
    ];

    /**
     * The attributes that define value is a instance of carbon.
     */
    protected $dates = [
        'dob'
    ];

    /**
     * The attributes that define validation rules.
     */
    public static $rules = [
        'user_id'       => 'required|exists:users,id'
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [];

    /**
     * The accessors to append to the model's array form.
     */
    protected $appends = [
        'pdob', 'is_dead_name', 'biological_name'
    ];

    /**
     * Enum `is_dead`.
     */
    public static $is_dead = [
        'MASIH HIDUP',
        'MENINGGAL'
    ];

    /**
     * Enum `biological`.
     */
    public static $biological = [
        'KANDUNG',
        'TIRI/ANGKAT'
    ];

    /**
     * Get is dead attributes.
     */
    public function getIsDeadNameAttribute () {
        return self::$is_dead[$this->is_dead] ?? null;
    }

    /**
     * Get biological attributes.
     */
    public function getBiologicalNameAttribute () {
        return self::$biological[$this->biological] ?? null;
    }

    /**
     * Get pdob attributes.
     */
    public function getPdobAttribute () {
        return join(', ', array_filter([$this->pob ?: null, $this->dob ? $this->dob->formatLocalized('%d %b %Y') : null], function($v){ return $v != null; }));
    }    

    /**
     * This belongs to user.
     */
    public function user () {
        return $this->belongsTo(User::class);
    }

    /**
     * This belongs to employment.
     */
    public function employment () {
        return $this->belongsTo('\App\Models\References\Employment', 'employment_id');
    }

    /**
     * This belongs to grade.
     */
    public function grade () {
        return $this->belongsTo('\App\Models\References\Grade', 'grade_id');
    }

    /**
     * This belongs to salary.
     */
    public function salary () {
        return $this->belongsTo('\App\Models\References\Salary', 'salary_id');
    }

    /**
     * This belongs to district.
     */
    public function district () {
        return $this->belongsTo('\App\Models\References\ProvinceRegencyDistrict', 'district_id');
    }

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
}
