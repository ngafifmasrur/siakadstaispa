<?php

namespace Modules\Admission\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{

    /**
     * The table associated with the model.
     */
    protected $table = "ref_questions";

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'cbt_id', 'soal', 'jawaban_a', 'jawaban_b', 'jawaban_c','jawaban_d','jawaban_e','jawaban_benar','skor'
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
    public function cbt () {
        return $this->belongsTo(Admission::class, 'cbt_id');
    }
}
