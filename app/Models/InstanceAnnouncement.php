<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InstanceAnnouncement extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     */
    protected $table = "inst_announcements";

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'inst_id', 'title', 'content', 'url'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     */
    protected $hidden = [
        'inst_id'
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
    public static $rules = [
        'inst_id'        => 'required|exists:insts,id',
        'title'             => 'required|string|max:191',
        'content'           => 'required|string|max:191',
        'url'               => 'string|max:191',
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [];

    /**
     * This belongs to inst.
     */
    public function instance () {
        return $this->belongsTo(Instance::class, 'inst_id')->withDefault();;
    }
}
