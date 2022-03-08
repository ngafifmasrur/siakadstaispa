<?php

namespace Modules\Admission\Models;

use App\Models\Scopes\OrderByIdDescScope;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdmissionPaymentItem extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     */
    protected $table = "admission_payment_items";

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'payment_id', 'name', 'amount', 'category_id', 'minimum'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     */
    protected $hidden = [
        'payment_id', 'category_id'
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
        return $this->belongsTo(AdmissionPayment::class, 'payment_id');
    }

    /**
     * This belongs to category.
     */
    public function category () {
        return $this->belongsTo(AdmissionPaymentCategory::class, 'category_id');
    }
}
