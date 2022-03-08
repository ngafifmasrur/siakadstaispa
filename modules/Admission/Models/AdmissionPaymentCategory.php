<?php

namespace Modules\Admission\Models;

use App\Models\Scopes\OrderByIdDescScope;

use Illuminate\Database\Eloquent\Model;

class AdmissionPaymentCategory extends Model
{
    /**
     * The table associated with the model.
     */
    protected $table = "admission_payment_categories";

    /**
     * Indicates if the model should be timestamped.
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'admission_id', 'kd', 'name'
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
     * This has many payments.
     */
    public function payments () {
        return $this->hasMany(AdmissionPayment::class, 'category_id');
    }
}
