<?php

namespace App\Models\References;

use Illuminate\Database\Eloquent\Model;

class AchievementType extends Model
{
    protected $table = "ref_achievement_types";

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name', 'description'
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
        'name'              => 'required|string|max:191',
        'description'       => 'nullable|string|max:191',
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [];
}
