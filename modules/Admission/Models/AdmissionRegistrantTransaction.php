<?php

namespace Modules\Admission\Models;

use App\Models\Scopes\OrderByIdDescScope;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdmissionRegistrantTransaction extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     */
    protected $table = "admission_registrant_transactions";

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'kd', 'registrant_id', 'payer', 'cash', 'value', 'amount', 'description', 'payed_at', 'committee_id'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     */
    protected $hidden = [
        'registrant_id', 'committee_id'
    ];

    /**
     * The attributes that define value is a instance of carbon.
     */
    protected $dates = [
        'payed_at', 'deleted_at', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that define validation rules.
     */
    public static $rules = [];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [
        'value'     => 'collection'
    ];

    /**
     * Enum `cash`.
     */
    public static $cash = [
        'NON-TUNAI',
        'TUNAI'
    ];

    /**
     * This belongs to registrant.
     */
    public function registrant () {
        return $this->belongsTo(AdmissionRegistrant::class, 'registrant_id');
    }

    /**
     * This belongs to committee.
     */
    public function committee () {
        return $this->belongsTo(AdmissionCommitteeMember::class, 'committee_id')->withDefault();
    }

    /**
     * Get cash attributes.
     */
    public function getCashNameAttribute () {
        return self::$cash[$this->cash] ?? null;
    }
}
