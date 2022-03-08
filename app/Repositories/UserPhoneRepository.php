<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\UserRepository;

class UserPhoneRepository extends UserRepository
{
    /**
     * Get and update detailed resource.
     */
    public function update($data, User $user)
    {
        if ($user->phone()->updateOrCreate(['user_id' => $user->id], $data)) {
            return $user;
        }

        return false;
    }
}
