<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InstPeriodSemester extends Model
{
    /**
     * The table associated with the model.
     */
    protected $table = "inst_period_semesters";

    /**
     * Indicates if the model should be timestamped.
     */
    public $timestamps = false;
    
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'period_id', 'open', 'name'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     */
    protected $hidden = [
        'period_id'
    ];

    /**
     * The attributes that define value is a instance of carbon.
     */
    protected $dates = [];

    /**
     * The attributes that define validation rules.
     */
    public static $rules = [];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [];

    /**
     * Get where open period semester
     */
    public function scopeWhereOpen($query)
    {
        return $query->where('open', 1);
    }

    /**
     * This belongs to period.
     */
    public function period() {
        return $this->belongsTo(InstancePeriod::class, 'period_id')->withDefault();
    }
}
