<?php

namespace Modules\Admission\Models;

use Illuminate\Database\Eloquent\Model;

class AdmissionCommitteeJob extends Model
{    
    /**
     * The table associated with the model.
     */
    protected $table = "admission_committee_jobs";

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'committee_id', 'job'
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
    public static $rules = [];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [];

    /**
     * This belongs to committee.
     */
    public function committee () {
        return $this->belongsTo(AdmissionCommittee::class, 'committee_id');
    }
}
