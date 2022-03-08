<?php

namespace Modules\Admission\Models;

use App\Models\Scopes\OrderByIdDescScope;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdmissionSession extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     */
    protected $table = "admission_sessions";

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'admission_id', 'name', 'start_time', 'end_time'
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
     * The accessors to append to the model's array form.
     */
    protected $appends = [
        'range'
    ];

    /**
     * This belongs to admission.
     */
    public function admission () {
        return $this->belongsTo(Admission::class, 'admission_id');
    }

    /**
     * This has many registrants.
     */
    public function registrants () {
        return $this->hasMany(AdmissionRegistrant::class, 'registrant_id');
    }

    /**
     * Get range attributes.
     */
    public function getRangeAttribute()
    {
        return substr($this->start_time, 0, 5).'-'.substr($this->end_time, 0, 5);
    }
}
