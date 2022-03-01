<?php

namespace App\Models\References;

use Illuminate\Database\Eloquent\Model;

class GradeLevel extends Model
{
    protected $table = "ref_grade_levels";

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'kd', 'rome', 'name'
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
        'kd'                => 'required|unique:grade_levels,kd',
        'rome'              => 'nullable|string',
        'name'              => 'required|string'
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [];

    /**
     * This belongs to grade.
     */
    public function grade () {
        return $this->belongsTo(Grade::class, 'grade_id');
    }
}
