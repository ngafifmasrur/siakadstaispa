<?php

namespace Modules\Account\Repositories;

use App\Models\User;
use App\Models\UserProfile;

class UserRepository
{
    /**
     * Instance the main property.
     */    
    public $model;

    /**
     * Pagination limit (set false to disable pagination).
     */    
    public $limit = 10;

    /**
     * Pagination limit (set false to disable pagination).
     */    
    public $trashed = false;

    /**
     * Create a new controller instance.
     */
    public function __construct(User $user)
    {
        $this->model = $user;
    }

    /**
     * Get all resources.
     */
    public function getAll()
    {
        return $this->model->get();
    }

    /**
     * Search resources with query.
     */
    public function search($query = '')
    {
        $users = $this->model;
                
        if ($this->trashed)
            $users = $users->onlyTrashed();

        $users = $users->where(function($user) use ($query) {
                        $user->where('username', 'like', '%'.$query.'%')
                              ->orWhereHas('profile', function($profile) use ($query) {
                                    $profile->where('name', 'like', '%'.$query.'%');
                                });
                    });

        return $this->limit ? $users->paginate($this->limit) : $users->get();
    }

    /**
     * Store resource.
     */
    public function store($data)
    {
        $user = $this->model->fill($data);

        if ($user->save()) {
            $profile = new UserProfile([
                'name' => $data['name']
            ]);
            $user->profile()->save($profile);

            return $user;
        }

        return false;
    }

    /**
     * Get detailed resource.
     */
    public function show(User $user)
    {
        return $user;
    }

    /**
     * Find by email.
     */
    public function findByEmail($address, $verified = false)
    {
        return $this->model
                    ->whereHas('email', function ($email) use ($address, $verified) {
                            $email->where('address', $address)
                                  ->when($verified, function ($query) {
                                      $query->whereNotNull('verified_at');
                                  });
                        })
                    ->first();
    }

    /**
     * Get and update detailed resource.
     */
    public function update($data, User $user)
    {
        return $user->update($data) ? $user : false;
    }

    /**
     * Get and delete detailed resource.
     */
    public function delete(User $user)
    {
        $tmp = $user;

        return $user->delete() ? $tmp : false;
    }

    /**
     * Get and restore detailed resource.
     */
    public function restore(User $user)
    {
        return $user->restore() ? $user : false;
    }

    /**
     * Get and kill detailed resource.
     */
    public function kill(User $user)
    {
        $tmp = $user;

        return $user->forceDelete() ? $tmp : false;
    }

    /**
     * Sync roles to user.
     */
    public function syncRoles($data, User $user)
    {
        return $user->syncRoles($data) ? $user : false;
    }
}
