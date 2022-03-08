<?php

namespace App\Repositories;

use App\Models\Permission;

class PermissionRepository
{
    /**
     * Instance the main property.
     */    
    protected $permissions;

    /**
     * Pagination limit (set false to disable pagination).
     */    
    public $limit = 10;

    /**
     * Create a new controller instance.
     */
    public function __construct(Permission $permissions)
    {
        $this->permissions = $permissions;
    }

    /**
     * Get all resources.
     */
    public function getAll()
    {
        return $this->permissions->get();
    }

    /**
     * Search resources with query.
     */
    public function search($query = '')
    {
        $permissions = $this->permissions
                            ->where('display_name', 'like', '%'.$query.'%')
                            ->orWhere('name', 'like', '%'.$query.'%');

        return $this->limit ? $permissions->paginate($this->limit) : $permissions->get();
    }

    /**
     * Store resource.
     */
    public function store($data)
    {
        $permissions = $this->permissions->fill($data);
        if ($permissions->save()) {
            $permissions->assignRole(config('admin.protectedRole'));

            return $permissions;
        }
        return false;
    }
}
