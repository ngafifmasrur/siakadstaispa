<?php

namespace Modules\Admission\Models;

use App\Models\User;
use App\Scopes\CurrentInstance;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdmissionRegistrant extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     */
    protected $table = "admission_registrants";

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'kd', 'admission_id', 'kd', 'user_id', 'avatar', 'major1', 'major2', 'agreement', 'payment_id', 'test_at', 'session_id', 'verified_at', 'tested_at', 'validated_at', 'agreement_at', 'paid_off_at', 'accepted_at', 'special', 'is_saman', 'jadwal_wawancara'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     */
    protected $hidden = [
        'session_id', 'payment_id'
    ];

    /**
     * The attributes that define value is a instance of carbon.
     */
    protected $dates = [
        'test_at', 'verified_at', 'tested_at', 'validated_at', 'paid_off_at', 'accepted_at', 'deleted_at', 'created_at', 'updated_at'
    ];

    /**
     * The accessors to append to the model's array form.
     */
    protected $appends = [
        'step_status', 'major_1_name', 'major_2_name'
    ];

    /**
     * Enum `major`.
     */
    public static $major = [
        'IAT',
        'IT',
        'PBA',
        'PGMI',
        'KPI'
    ];

    /**
     * Enum `major`.
     */
    public static $major_long = [
        'ILMU AL-QUR\'AN DAN TAFSIR',
        'ILMU TASAWUF',
        'PENDIDIKAN BAHASA ARAB',
        'PENDIDIKAN GURU MADRASAH IBTIDAIYAH',
        'KOMUNIKASI DAN PENYIARAN ISLAM'
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
     * Retrieve the model for a bound value.
     */
    public function resolveRouteBinding($value)
    {
        return $this->withTrashed()->where($this->getRouteKeyName(), $value)->first();
    }

    /**
     * The "booting" method of the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new CurrentInstance('admission.period'));
    }
    
    /**
     * Get major1 attributes.
     */
    public function getMajor1NameAttribute () {
        return self::$major[$this->major1] ?? null;
    }
    
    /**
     * Get major2 attributes.
     */
    public function getMajor2NameAttribute () {
        return self::$major[$this->major2] ?? null;
    }

    /**
     * This belongs to admission.
     */
    public function admission () {
        return $this->belongsTo(Admission::class, 'admission_id');
    }

    /**
     * This belongs to user.
     */
    public function user () {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * This belongs to session.
     */
    public function session () {
        return $this->belongsTo(AdmissionSession::class, 'session_id')->withDefault();
    }

    /**
     * This has many transactions.
     */
    public function transactions () {
        return $this->hasMany(AdmissionRegistrantTransaction::class, 'registrant_id');
    }

    /**
     * This belongs to payment.
     */
    public function payment () {
        return $this->belongsTo(AdmissionPayment::class, 'payment_id')->withDefault();
    }

    /**
     * This belongs to many tests.
     */
    public function tests () {
        return $this->belongsToMany(AdmissionTest::class, 'admission_registrant_tests', 'registrant_id', 'test_id')->withPivot(['value', 'description', 'committee_id'])->withTimestamps();
    }

    /**
     * This belongs to many files.
     */
    public function files () {
        return $this->belongsToMany(AdmissionFile::class, 'admission_registrant_files', 'registrant_id', 'file_id')->withPivot(['file', 'description'])->withTimestamps();
    }

    /**
     * This belongs to many majors.
     */
    public function majors () {
        return $this->belongsToMany(CollegeFacultyMajor::class, 'admission_registrant_majors', 'registrant_id', 'major_id')->withPivot(['az']);
    }

    /**
     * Get the current registrant
     */
    public function scopeCurrentUser($query, $user = false)
    {
        return $query->where('user_id', $user ? $user->id : auth()->user()->id)
                     ->whereHas('admission', function($admission) {
                        $admission->where('open', 1);
                     });
    }

    /**
     * Get the current registrant
     */
    public function scopeWhereAdmissionIsOrAll($query, $model = false)
    {
        return $query->when($model, function($query, $model) {
                        return $query->whereIn('admission_id', $model->pluck('id'));
                    });
    }

    /**
     * Get nullable field.
     */
    public function nullFields($array = [])
    {
        $req = count($array) ? $array : ['pob', 'dob', 'sex', 'country_id', 'nokk', 'nik', 'child_order', 'siblings', 'biological', 'nisn'];

        return array_values(array_filter($req, function ($v) {
            return $this->user->profile->{$v} === null;
        }));
    }

    /**
     * Get registrant status.
     */
    public function getStepStatusAttribute()
    {
        if($this->verified_at):
            if($this->tested_at):
                if($this->paid_off_at):
                    if($this->accepted_at):
                        return 'Diterima';
                    else:
                        return 'Lunas pembayaran';
                    endif;
                else:
                    if($this->accepted_at):
                        return 'Diterima belum lunas';
                    else:
                        if($this->transactions()->exists()):
                            return 'Belum lunas';
                        else:
                            if($this->validated_at):
                                return 'Data valid';
                            else:
                                return 'Lulus tes';
                            endif;
                        endif;
                    endif;
                endif;
            else:
                if($this->tests()->exists()):
                    return 'Belum lulus tes';
                else:
                    return 'Terverifikasi';
                endif;
            endif;
        else:
            return 'Belum verifikasi';
        endif;
    }
}
