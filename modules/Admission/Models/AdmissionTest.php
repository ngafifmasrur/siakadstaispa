<?php

namespace Modules\Admission\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdmissionTest extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     */
    protected $table = "admission_tests";

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'admission_id', 'name', 'minimal'
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
     * This belongs to admission.
     */
    public function admission () {
        return $this->belongsTo(Admission::class, 'admission_id');
    }

    /**
     * This belongs to many registrants.
     */
    public function registrants () {
        return $this->belongsToMany(AdmissionRegistrant::class, 'admission_registrant_tests', 'test_id', 'registrant_id');
    }
}
