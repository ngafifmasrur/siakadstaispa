<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\UserStudy;
use App\Repositories\UserRepository;

class UserStudyRepository
{
    /**
     * Instance the main property.
     */    
    public $model;

    /**
     * Create a new controller instance.
     */
    public function __construct(User $user)
    {
        $this->model = $user;
    }

    /**
     * Get and store resource.
     */
    public function store($data, User $user)
    {
        $study = new UserStudy($data);

        if ($user->studies()->save($study)) {
            return $study;
        }

        return false;
    }

    /**
     * Get and update detailed resource.
     */
    public function update($data, User $user)
    {
        $study = $user->studies()->find($data['__id']);

        if ($study->update($data)) {
            return $study;
        }

        return false;
    }

    /**
     * Get and delete detailed resource.
     */
    public function delete($data, User $user)
    {
        $study = $user->studies()->find($data['__id']);

        $tmp = $study;

        if ($study->delete()) {
            return $tmp;
        }

        return false;
    }
}
