<?php

namespace App\Interfaces\Repositories;

use App\Models\User;
use Illuminate\Support\Collection;
use App\Models\Role;

interface UserRepositoryInterface
{
    /**
     * Create a new user
     * @param string $email
     * @param string $password
     * @param string $name
     * @return User
     */
    public function createUser(User $user): User;

    /**
     * Get a user by its UUID
     * @param string $user_uuid
     * @return User
     */
    public function getUserById(string $user_id): User;

    /**
     * Update a user
     * @param string $uuid
     * @param string $email
     * @param string $name
     * @return User
     */
    public function updateUser(User $user): User;

    /**
     * Delete a user
     * @param string $uuid
     * @return bool
     */
    public function deleteUser(string $user_id): bool;

    /**
     * Get all users
     * @return Collection
     */
    public function getUsers(): Collection;

    /**
     * Get a user by its email
     * @param string $email
     * @return User
     */
    public function getUserByEmail(string $email): ?User;

    /**
     * Add a role to a user
     * @param User $user
     * @param Role $role
     * @return bool
     */
    public function addRoleToUser(User $user, Role $role): bool;

    /**
     * Remove a role from a user
     * @param User $user
     * @param Role $role
     * @return bool
     */
    public function removeRoleFromUser(User $user, Role $role): bool;

   
}