<?php

namespace Modules\Admission\Models;

use Illuminate\Database\Eloquent\Model;

class AdmissionPermission extends Model
{
    
    
    /**
     * The table associated with the model.
     */
    protected $table = "admission_permissions";

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'admission_id', 'name', 'display_name', 'description'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     */
    protected $hidden = [
        'admission_id'
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
     * This belongs to many permissions.
     */
    public function permissions () {
        return $this->belongsToMany(AdmissionCommittee::class, 'admission_committee_permissions', 'permission_id', 'committee_id');
    }
}
