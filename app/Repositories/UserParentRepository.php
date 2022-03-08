<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\UserRepository;

class UserParentRepository extends UserRepository
{
    /**
     * Get and update detailed resource.
     */
    public function update($data, User $user)
    {
        if ($user->{$data['__type']}()->updateOrCreate(['user_id' => $user->id], $data)) {
            return $user;
        }

        return false;
    }
}
