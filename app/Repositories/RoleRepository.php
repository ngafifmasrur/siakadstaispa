<?php

namespace App\Repositories;

use App\Models\Role;
use App\Models\Permission;

class RoleRepository
{
    /**
     * Instance the main property.
     */    
    protected $roles;
    protected $permissions;

    /**
     * Pagination limit (set false to disable pagination).
     */    
    public $limit = 10;

    /**
     * Create a new controller instance.
     */
    public function __construct(Role $roles, Permission $permissions)
    {
        $this->roles = $roles;
        $this->permissions = $permissions;
    }

    /**
     * Get all resources.
     */
    public function getAll()
    {
        return $this->roles->get();
    }

    /**
     * Search resources with query.
     */
    public function search($query = '')
    {
        $roles = $this->roles
                      ->where('name', 'like', '%'.$query.'%')
                      ->orderByDesc('created_at');

        return $this->limit ? $roles->paginate($this->limit) : $roles->get();
    }

    /**
     * Store resource.
     */
    public function storeWithSync(array $data, array $permissions)
    {
        $roles = $this->roles->fill($data);

        if ($roles->save()) {

            $roles->syncPermissions($permissions);

            return $roles;

        }

        return false;
    }

    /**
     * Get detailed resource.
     */
    public function show($id)
    {
        return $this->roles->withCount('users')
                           ->with('creator')
                           ->whereNotIn('id', config('admin.protectedRole'))
                           ->findOrFail($id);
    }

    /**
     * Get and update detailed resource.
     */
    public function updateAndSync($id, $data, $permissions)
    {
        $roles = $this->roles
                      ->whereNotIn('id', config('admin.protectedRole'))
                      ->findOrFail($id);

        $roles->fill(array_merge($data, [
            'updated_at' => date('Y-m-d H:i:s')
        ]));

        if ($roles->save()) {
            $roles->syncPermissions($permissions);
            
            return $roles;
        }

        return false;
    }

    /**
     * Get and delete detailed resource.
     */
    public function delete($id)
    {
        $roles = $this->roles
                      ->whereNotIn('id', config('admin.protectedRole'))
                      ->findOrFail($id);

        $tmp = $roles;

        if ($roles->delete()) {
            return $tmp;
        }

        return false;
    }
}
