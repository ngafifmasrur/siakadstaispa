<?php

namespace Modules\Admission\Models;

use Illuminate\Database\Eloquent\Model;

class AdmissionSpending extends Model
{   
    /**
     * The table associated with the model.
     */
    protected $table = "admission_spendings";

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'admission_id', 'item', 'amount', 'qty', 'unit', 'shop', 'committee_id', 'buyer', 'payed_at', 'receipt'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     */
    protected $hidden = [
        'admission_id', 'committee_id'
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
     * Enum `unit`.
     */
    public static $unit = [
        'pcs',
        'buah',
        'unit',
        'eks',
        'rim',
        'lainnya'
    ];

    /**
     * Get unit attributes.
     */
    public function getUnitNameAttribute () {
        return self::$unit[$this->unit] ?? null;
    }

    /**
     * This belongs to admission.
     */
    public function admission () {
        return $this->belongsTo(Admission::class, 'admission_id');
    }

    /**
     * This belongs to committee.
     */
    public function committee () {
        return $this->belongsTo(AdmissionCommittee::class, 'committee_id');
    }
}
