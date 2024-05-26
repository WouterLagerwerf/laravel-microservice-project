<?php

namespace App\Services;

use App\DTOs\RoleDTO;
use App\Exceptions\Roles\RoleNotFoundException;
use App\Exceptions\Roles\RoleException;
use App\Repositories\RoleRepository;
use App\Interfaces\Services\RoleServiceInterface;
use Exception;

class RoleService implements RoleServiceInterface
{

    public function __construct(
        private readonly RoleRepository $roleRepository
    ) {}

    /**
     * Get a specific role by its id.
     * @param string $id
     * @return RoleDTO
     */
    public function getRoleById(string $id): RoleDTO
    {
        try {
            $role = $this->roleRepository->getRoleById($id);
            if (!$role) {
                throw new RoleNotFoundException(message: 'Role does not exist', status: 404);
            }

            return new RoleDTO($role->id, $role->name);
        } catch (Exception $e) {
            throw new RoleException(message: 'Failed to get role', status: 500);
        }

        return RoleDTO::fromModel($role);
    }
}