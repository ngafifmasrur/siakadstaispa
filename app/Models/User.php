<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

use Modules\Admission\Models\Traits\UserAdmissionCommitteeTrait;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes, UserAdmissionCommitteeTrait;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'username', 'password', 'level'
    ];

    /**
     * The attributes that should be hidden for arrays.
     */
    protected $hidden = [
        'password', 'remember_token', 'level'
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [];

    /**
     * The attributes that define value is a instance of carbon.
     */
    protected $dates = [
        'deleted_at', 'created_at', 'updated_at'
    ];

    /**
     * The relations to eager load on every query.
     */
    public $with = [
        'profile', 'email', 'phone', 'address'
    ];

    /**
     * The accessors to append to the model's array form.
     */
    protected $appends = [
        'full_username'
    ];

    /**
     * Retrieve the model for a bound value.
     */
    public function resolveRouteBinding($value)
    {
        return $this->withTrashed()->where($this->getRouteKeyName(), $value)->first();
    }

    /**
     * Route notifications for the mail channel.
     */
    public function routeNotificationForMail($notification)
    {
        return $this->email->address;
    }

    /**
     * Generate password.
     */
    public static function generatePassword ($length = 6) {
        return substr(str_shuffle('ABCDEF0123456789'), 0, $length);
    }

    /**
     * Get username attributes.
     */
    public function getFullUsernameAttribute () {
        return $this->username.'@'.env('APP_DOMAIN');
    }

    /**
     * This has many email.
     */
    public function email () {
        return $this->hasOne(UserEmail::class)->withDefault();
    }

    /**
     * This has many phone.
     */
    public function phone () {
        return $this->hasOne(UserPhone::class)->withDefault();
    }

    /**
     * This has one profile.
     */
    public function profile () {
        return $this->hasOne(UserProfile::class, 'user_id')->withDefault();
    }

    /**
     * This has one broker.
     */
    public function broker () {
        return $this->hasOne(UserPasswordReset::class);
    }

    /**
     * This has one father.
     */
    public function father () {
        return $this->hasOne(UserFather::class, 'user_id')->withDefault();
    }

    /**
     * This has one mother.
     */
    public function mother () {
        return $this->hasOne(UserMother::class, 'user_id')->withDefault();
    }

    /**
     * This has one foster.
     */
    public function foster () {
        return $this->hasOne(UserFoster::class, 'user_id')->withDefault();
    }

    /**
     * Belongs to many disabilities.
     */
    public function disabilities()
    {
        return $this->belongsToMany('\App\Models\References\Disability', 'user_disabilities', 'user_id', 'disability_id');
    }

    /**
     * This has one address.
     */
    public function address () {
        return $this->hasOne(UserAddress::class, 'user_id')->withDefault();
    }

    /**
     * This has many studies.
     */
    public function studies () {
        return $this->hasMany(UserStudy::class, 'user_id');
    }

    /**
     * This has many organizations.
     */
    public function organizations () {
        return $this->hasMany(UserOrganization::class, 'user_id');
    }

    /**
     * This has many achievements.
     */
    public function achievements () {
        return $this->hasMany(UserAchievement::class, 'user_id');
    }

    /**
     * This has many appreciations.
     */
    public function appreciations () {
        return $this->hasMany(UserAppreciation::class, 'user_id');
    }
    
    /**
     * This has one registrant.
     */
    public function registrant () {
        return $this->hasOne(\Modules\Admission\Models\AdmissionRegistrant::class, 'user_id');
    }
}
