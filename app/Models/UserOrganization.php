<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserOrganization extends Model
{
    /**
     * The table associated with the model.
     */
    protected $table = "user_organizations";

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name', 'type_id', 'year', 'duration', 'position_id', 'file', 'description'
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
        'type_id'           => 'required|exists:ref_organization_types,id',
        'year'              => 'required|date_format:Y',
        'duration'          => 'required|digits__between:0,3',
        'position_id'       => 'required|exists:ref_organization_positions,id',
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
        return $this->belongsTo(\App\Models\References\OrganizationType::class)->withDefault();
    }

    /**
     * This belongs to position.
     */
    public function position () {
        return $this->belongsTo(\App\Models\References\OrganizationPosition::class)->withDefault();
    }
}
