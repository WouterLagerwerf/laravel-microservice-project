<?php 

namespace App\Repositories;

use App\Models\Role;
use App\Exceptions\Roles\RoleNotFoundException;
use App\Interfaces\Repositories\RoleRepositoryInterface;

class RoleRepository implements RoleRepositoryInterface
{
    /**
     * Get a specific role by its id.
     * @param string $id
     * @return Role
     */
    public function getRoleById(string $id): Role
    {
        try {
            return Role::find($id);
        } catch (\Exception $e) {
            throw new RoleNotFoundException(message: 'Role does not exist', status: 404);
        }
    }
}