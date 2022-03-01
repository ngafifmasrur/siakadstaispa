<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAchievement extends Model
{
    /**
     * The table associated with the model.
     */
    protected $table = "user_achievements";

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name', 'territory_id', 'type_id', 'num_id', 'year', 'file', 'description'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     */
    protected $hidden = [
        'type_id', 'position_id'
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
        'name'              => 'required|string|max:191',
        'territory_id'      => 'required|exists:ref_territories,id',
        'type_id'           => 'required|exists:ref_achievement_types,id',
        'num_id'            => 'required|exists:ref_achievement_nums,id',
        'year'              => 'required|date_format:Y',
        'file'              => 'nullable|file|image|max:1024',
        'description'       => 'nullable|string|max:191',
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [];

    /**
     * This belongs to user.
     */
    public function user () {
        return $this->belongsTo(User::class);
    }

    /**
     * This belongs to type.
     */
    public function type () {
        return $this->belongsTo(\App\Models\References\AchievementType::class)->withDefault();
    }

    /**
     * This belongs to num.
     */
    public function num () {
        return $this->belongsTo(\App\Models\References\AchievementNum::class)->withDefault();
    }

    /**
     * This belongs to territory.
     */
    public function territory () {
        return $this->belongsTo(\App\Models\References\Territory::class)->withDefault();
    }
}
