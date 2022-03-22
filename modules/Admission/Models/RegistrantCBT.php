<?php

namespace Modules\Admission\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RegistrantCBT extends Model
{

    /**
     * The table associated with the model.
     */
    protected $table = "t_registrant_cbt";

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'registrant_id', 'cbt_id', 'waktu_mulai', 'waktu_selesai', 'total_skor', 'status', 'sisa_waktu', 'jumlah_jawaban_benar'
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
    public function admission_cbt () {
        return $this->belongsTo(AdmissionCBT::class, 'cbt_id');
    }

    /**
     * This belongs to many registrants.
     */
    public function registrant () {
        return $this->belongsTo(AdmissionRegistrant::class, 'registrant_id');
    }
}
