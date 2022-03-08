<?php

namespace App\Rules;

use App\Models\UserEmail;
use Illuminate\Contracts\Validation\Rule;

class VerifiedEmail implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return UserEmail::where('address', $value)
                        ->whereNotNull('verified_at')
                        ->count();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Mohon maaf, terjadi kegagalan, pastikan e-mail Anda telah terverifikasi.';
    }
}