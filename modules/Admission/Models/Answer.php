<?php

namespace Modules\Admission\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Answer extends Model
{

    /**
     * The table associated with the model.
     */
    protected $table = "t_answers";

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'registrant_id', 'question_id', 'jawaban_benar', 'jawaban_peserta', 'skor', 'status'
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
    public function registrant () {
        return $this->belongsTo(AdmissionRegistrant::class, 'registrant_id');
    }

        /**
     * This belongs to many registrants.
     */
    public function question () {
        return $this->belongsTo(Question::class, 'question_id');
    }
}
