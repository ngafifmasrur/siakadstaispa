<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\UserOrganization;
use App\Repositories\UserRepository;

class UserOrganizationRepository
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
        $organization = new UserOrganization($data);

        if ($user->organizations()->save($organization)) {
            return $organization;
        }

        return false;
    }

    /**
     * Get and update detailed resource.
     */
    public function update($data, User $user)
    {
        $organization = $user->organizations()->find($data['__id']);

        if ($organization->update($data)) {
            return $organization;
        }

        return false;
    }

    /**
     * Get and delete detailed resource.
     */
    public function delete($data, User $user)
    {
        $organization = $user->organizations()->find($data['__id']);

        $tmp = $organization;

        if ($organization->delete()) {
            return $tmp;
        }

        return false;
    }
}
