<?php 

namespace App\Interfaces\Repositories;
use App\Models\Role;

interface RoleRepositoryInterface
{
    /**
     * Get a specific role by its id.
     * @param string $id
     * @return Role
     */
    public function getRoleById(string $id): Role;
}