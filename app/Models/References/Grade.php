<?php

namespace App\Models\References;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $table = "ref_grades";

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name', 'kd'
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
        'name'              => 'required|string',
        'kd'                => 'nullable|numeric'
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [];

    /**
     * This has many levels.
     */
    public function levels () {
        return $this->hasMany(GradeLevel::class, 'grade_id');
    }

    /**
     * This has many instances.
     */
    public function instanceances () {
        return $this->hasMany(Instance::class);
    }
}
