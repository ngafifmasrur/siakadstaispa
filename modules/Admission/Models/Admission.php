<?php

namespace Modules\Admission\Models;

use App\Scopes\CurrentInstance;
use Illuminate\Database\Eloquent\Model;

class Admission extends Model
{
    /**
     * The table associated with the model.
     */
    protected $table = "admissions";

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'period_id', 'name', 'generation', 'open', 'start_date', 'end_date', 'published'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     */
    protected $hidden = [
        'period_id'
    ];

    /**
     * The attributes that define value is a instance of carbon.
     */
    protected $dates = [
        'start_date', 'end_date', 'created_at', 'updated_at'
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
        'full_name'
    ];

    /**
     * The "booting" method of the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new CurrentInstance());
    }

    /**
     * This belongs to period.
     */
    public function period () {
        return $this->belongsTo('\App\Models\InstancePeriod', 'period_id');
    }

    /**
     * This has many files.
     */
    public function files () {
        return $this->hasMany(AdmissionFile::class, 'admission_id');
    }

    /**
     * This has many forms.
     */
    public function forms () {
        return $this->hasMany(AdmissionForm::class, 'admission_id');
    }

    /**
     * This has registrants.
     */
    public function registrants () {
        return $this->hasMany(AdmissionRegistrant::class, 'admission_id');
    }

    /**
     * This has sessions.
     */
    public function sessions () {
        return $this->hasMany(AdmissionSession::class, 'admission_id');
    }

    /**
     * This has payments.
     */
    public function payments () {
        return $this->hasMany(AdmissionPayment::class, 'admission_id');
    }

    /**
     * This has paymentCategories.
     */
    public function paymentCategories () {
        return $this->hasMany(AdmissionPaymentCategory::class, 'admission_id');
    }

    /**
     * This has test dates.
     */
    public function testDates () {
        return $this->hasMany(AdmissionTestDate::class, 'admission_id');
    }

    /**
     * This has general requirements.
     */
    public function generalRequirements () {
        return $this->hasMany(AdmissionGeneralRequirement::class, 'admission_id');
    }

    /**
     * This has special requirements.
     */
    public function specialRequirements () {
        return $this->hasMany(AdmissionSpecialRequirement::class, 'admission_id');
    }

    /**
     * This has test kinds.
     */
    public function tests () {
        return $this->hasMany(AdmissionTest::class, 'admission_id');
    }

    /**
     * This has many committees.
     */
    public function committees () {
        return $this->hasMany(AdmissionCommittee::class, 'admission_id');
    }

    /**
     * This belongs to many committeeMember.
     */
    public function committeeMembers () {
        return $this->belongsToMany(\App\Models\User::class, 'admission_committee_users', 'committee_id', 'user_id');
    }

    /**
     * Get full name attribute.
     */
    public function getFullNameAttribute () {
        return $this->name.' '.$this->period->name;
    }

    /**
     * Scope current user.
     */
    public function scopeCurrentUser($query, $user = false)
    {
        return $query->whereHas('registrants', function ($registrants) use ($user) {
                    $registrants->where('user_id', $user ? $user->id : auth()->id());
                });
    }

    /**
     * Scope where opened.
     */
    public function scopeOpened($query)
    {
        return $query->where('open', 1);
    }

    /**
     * Scope where published.
     */
    public function scopePublished($query)
    {
        return $query->where('published', 1);
    }

    /**
     * Scope get opened or latest.
     */
    public function scopeWhereOpenedOrLatest($query)
    {
        return $query->orderByDesc('open')->orderByDesc('id');
    }

    /**
     * Get sum of registrants today.
     */
    public function getRegistrantsToday()
    {
        return $this->registrants()->whereDate('created_at', date('Y-m-d'))->count();
    }

    /**
     * Get grouped of registrants status.
     */
    public function getGroupedRegistrantsStatus()
    {
        return $this->registrants()
                    ->select(\DB::raw('
                            COUNT(IF(`verified_at` IS NULL AND `tested_at` IS NULL, 1 , NULL)) AS `Belum verifikasi`,
                            COUNT(IF(`verified_at` IS NOT NULL AND `tested_at` IS NULL, 1 , NULL)) AS `Terverifikasi`,
                            COUNT(IF(`tested_at` IS NOT NULL and `paid_off_at` IS NULL and `accepted_at` IS NULL AND NOT EXISTS 
                                (SELECT * FROM `admission_registrant_transactions` WHERE `admission_registrants`.`id` = `admission_registrant_transactions`.`registrant_id` and `admission_registrant_transactions`.`deleted_at` IS NULL), 1 , NULL)
                            ) AS `Lulus tes`,
                            COUNT(IF(`tested_at` IS NULL and `paid_off_at` IS NULL and `accepted_at` IS NULL AND EXISTS 
                                (SELECT * FROM `admission_registrant_tests` WHERE `admission_registrants`.`id` = `admission_registrant_tests`.`registrant_id` and `admission_registrant_tests`.`deleted_at` IS NULL), 1 , NULL)
                            ) AS `Belum lulus tes`,
                            COUNT(IF(`tested_at` IS NOT NULL AND `paid_off_at` IS NULL AND `accepted_at` IS NULL AND EXISTS 
                                (SELECT * FROM `admission_registrant_transactions` WHERE `admission_registrants`.`id` = `admission_registrant_transactions`.`registrant_id` AND `admission_registrant_transactions`.`deleted_at` IS NULL), 1 , NULL)
                            ) AS `Belum lunas`,
                            COUNT(IF(`paid_off_at` IS NOT NULL AND `accepted_at` IS NULL, 1 , NULL)) AS `Lunas pembayaran`,
                            COUNT(IF(`accepted_at` IS NOT NULL AND `paid_off_at` IS NULL, 1 , NULL)) AS `Diterima belum lunas`,
                            COUNT(IF(`accepted_at` IS NOT NULL AND `paid_off_at` IS NOT NULL, 1 , NULL)) AS `Diterima belum dapat kamar`
                            COUNT(IF(`accepted_at` IS NOT NULL AND `paid_off_at` IS NOT NULL AND `room_id` IS NOT NULL AND `bed` IS NOT NULL, 1 , NULL)) AS `Diterima dapat kamar`
                        '))
                    ->first()
                    ->toArray();
    }

    /**
     * Get registrant sex.
     */
    public function getUserSex()
    {
        return Admission::with('registrants.user')->find($this->id)
                            ->registrants
                            ->pluck('user');
    }

    /**
     * Get registrant studies.
     */
    // public function getRegistrantStudies($limit = 5)
    // {
    //     return UserStudy::whereHas('user.student.registrant', function ($registrant) {
    //                 $registrant->where('admission_id', $this->id);
    //             });
    // }
}
