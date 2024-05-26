<?php

namespace App\Interfaces\Services;
use App\DTOs\RoleDTO;

interface RoleServiceInterface
{
    /**
     * Get a specific role by its id.
     * @param string $id
     * @return RoleDTO
     */
    public function getRoleById(string $id): RoleDTO;
}