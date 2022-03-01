<?php

namespace Modules\Admission\Models;

use Illuminate\Database\Eloquent\Model;

class AdmissionCommittee extends Model
{   
    /**
     * The table associated with the model.
     */
    protected $table = "admission_committees";

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'admission_id', 'name', 'display_name', 'description', 'az'
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
     * This belongs to admission.
     */
    public function admission () {
        return $this->belongsTo(Admission::class, 'admission_id');
    }

    /**
     * This has many jobs.
     */
    public function jobs () {
        return $this->hasMany(AdmissionCommitteeJob::class, 'committee_id');
    }

    /**
     * This belongs to many members.
     */
    public function members () {
        return $this->belongsToMany(User::class, 'admission_committee_members', 'committee_id', 'member_id');
    }

    /**
     * This belongs to many permissions.
     */
    public function permissions () {
        return $this->belongsToMany(AdmissionPermission::class, 'admission_committee_permissions', 'committee_id', 'permission_id');
    }
}
