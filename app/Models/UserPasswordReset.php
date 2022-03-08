<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPasswordReset extends Model
{
    /**
     * The table associated with the model.
     */
    protected $table = 'user_password_resets';

    /**
     * The primary key for the model.
     */
    public $primaryKey = 'user_id';

    /**
     * Indicates if the model should be timestamped.
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'token', 'expired_in'
    ];

    /**
     * The attributes that should be hidden for arrays.
     */
    protected $hidden = [
        'user_id'
    ];

    /**
     * The attributes that define value is a instance of carbon.
     */
    protected $dates = [];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [];

    /**
     * This belongs to user.
     */
    public function user () {
        return $this->belongsTo(User::class);
    }
}
