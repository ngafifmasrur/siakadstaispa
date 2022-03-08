<?php

namespace Modules\Admission\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdmissionPayment extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     */
    protected $table = "admission_payments";

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'admission_id', 'name', 'description'
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
     * This has many items.
     */
    public function items () {
        return $this->hasMany(AdmissionPaymentItem::class, 'payment_id');
    }

    /**
     * This has many registrants.
     */
    public function registrants () {
        return $this->hasMany(AdmissionRegistrant::class, 'payment_id');
    }

    /**
     * This has many transactions through registrants.
     */
    public function transactions () {
        return $this->hasManyThrough(AdmissionRegistrantTransaction::class, AdmissionRegistrant::class, 'payment_id', 'registrant_id');
    }
}
