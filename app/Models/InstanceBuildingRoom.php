<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InstanceBuildingRoom extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     */
    protected $table = "inst_building_rooms";

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'building_id', 'kd', 'name', 'capacity'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     */
    protected $hidden = [
        'building_id'
    ];

    /**
     * The attributes that define value is a instance of carbon.
     */
    protected $dates = [
        'deleted_at', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that define validation rules.
     */
    public static $rules = [];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [];

    /**
     * This belongs to inst.
     */
    public function building () {
        return $this->belongsTo(InstanceBuilding::class, 'building_id')->withDefault();;
    }
}
