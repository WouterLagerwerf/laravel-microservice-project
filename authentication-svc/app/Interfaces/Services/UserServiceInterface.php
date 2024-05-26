<?php 

namespace App\Interfaces\Services;

use App\DTOs\CreateUserDTO;
use App\DTOs\UpdateUserDTO;
use App\DTos\UserDTO;
use App\DTOs\AddRoleToUserDTO;
use App\DTOs\RemoveRoleFromUserDTO;

interface UserServiceInterface 
{   
    /**
     * Create a new user
     * @param string $email
     * @param string $password
     * @param string $name
     * @return array
     */
    public function createUser(CreateUserDTO $dto): UserDTO;

    /**
     * Get a user by its UUID
     * @param string $user_uuid
     * @return array
     */
    public function getUserById(string $user_id): UserDTO;

    /**
     * Update a user
     * @param string $uuid
     * @param string $email
     * @param string $name
     * @return array
     */
    public function updateUser(UpdateUserDTO $dto): UserDTO;

    /**
     * Delete a user
     * @param string $uuid
     * @return bool
     */
    public function deleteUser(string $user_id): bool;

    /**
     * Get all users
     * @return array[UserDTO]
     */
    public function getUsers(): array;

    /**
     * Add a role to a user
     * @param AddRoleToUserDTO $dto
     * @return array
     */
    public function addRoleToUser(AddRoleToUserDTO $dto): bool;

    /**
     * Remove a role from a user
     * @param RemoveRoleFromUserDTO $dto
     * @return array
     */
    public function removeRoleFromUser(RemoveRoleFromUserDTO $dto): bool;
}
