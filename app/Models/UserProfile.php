<?php

namespace App\Models;

use App\Models\References\Grade;
use App\Models\References\Salary;
use App\Models\References\Employment;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    /**
     * The table associated with the model.
     */
    protected $table = 'user_profile';

    /**
     * The primary key for the model.
     */
    protected $primaryKey = 'user_id';

    /**
     * Indicates if the model should be timestamped.
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name', 'prefix', 'suffix', 'pob', 'dob', 'sex', 'blood', 'nik', 'nokk', 'country_id', 'avatar', 'child_order', 'siblings', 'biological', 'illness', 'nisn'
    ];

    /**
     * The attributes that should be hidden for arrays.
     */
    protected $hidden = [
        'user_id', 'grade_id', 'employment_id', 'salary_id'
    ];

    /**
     * The attributes that define value is a instance of carbon.
     */
    protected $dates = [
        'dob'
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [
        'is_dead'   => 'boolean',
    ];

    /**
     * The accessors to append to the model's array form.
     */
    protected $appends = [
        'full_name', 'sex_name', 'blood_name', 'is_dead_name', 'biological_name'
    ];

    /**
     * Enum `sex`.
     */
    public static $sex = [
        'LAKI-LAKI',
        'PEREMPUAN'
    ];

    /**
     * Enum `blood`.
     */
    public static $blood = [
        'A',
        'B',
        'AB',
        'O',
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
     * This belongs to user.
     */
    public function user () {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get fullname attributes.
     */
    public function getFullNameAttribute () {
        return (join(', ', array_filter([join(' ', array_filter([$this->prefix, $this->name])), $this->suffix])) ?: null).($this->is_dead ? ' (ALM)' : '');
    }
    /**
     * Get sex attributes.
     */
    public function getSexNameAttribute () {
        return self::$sex[$this->sex] ?? null;
    }

    /**
     * Get sex attributes.
     */
    public function getBloodNameAttribute () {
        return self::$blood[$this->blood] ?? null;
    }

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
        return strtoupper(join(', ', array_filter([$this->pob ?: null, $this->dob ? $this->dob->formatLocalized('%d %B %Y') : null], function($v){ return $v != null; })));
    }

    /**
     * This belongs to country.
     */
    public function country () {
        return $this->belongsTo(\App\Models\References\Country::class, 'country_id');
    }
}
