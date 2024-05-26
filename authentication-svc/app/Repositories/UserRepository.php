<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Interfaces\Repositories\UserRepositoryInterface;
use App\Exceptions\Users\CreateUserException;
use App\Exceptions\Users\UpdateUserException;
use App\Exceptions\Users\UserNotFoundException;
use App\Exceptions\Users\DeleteUserException;
use Illuminate\Support\Collection;
use App\Exceptions\Users\AddRoleToUserException;
use App\Exceptions\Users\RemoveRoleFromUserException;
use App\Models\Role;

class UserRepository implements UserRepositoryInterface
{
    public function __construct(
        private readonly User $user
    ) {}

    /**
     * Create a new user
     * @param User $user
     * @return User
     * @throws CreateUserException
     */
    public function createUser(User $user): User
    {   
        try {
            DB::beginTransaction();
            $user = $this->user->create($user->toArray());
            DB::commit();
            return $user;
        } catch (Exception $e) {
            DB::rollBack();
            throw new CreateUserException(status: 500, message: 'Failed to create user');
        }
    }

    /**
     * Get a user by its ID
     * @param string $user_id
     * @return User
     * @throws UserNotFoundException
     */
    public function getUserById(string $user_id): User
    {
        $user = $this->user->find($user_id);

        if (empty($user)) {
            throw new UserNotFoundException(status: 404, message: 'User not found');
        }
        return $user;
    }

    /**
     * Update a user
     * @param string $uuid
     * @param string $email
     * @param string $name
     * @return User
     * @throws UpdateUserException
     */
    public function updateUser(User $user): User
    {
        try {
            DB::beginTransaction();
            $user = $this->user->update($user->toArray());
            DB::commit();
            return $user;
        } catch (Exception $e) {
            DB::rollBack();
            throw new UpdateUserException(status: 500, message: 'Failed to update user');
        }
    }

    /**
     * Delete a user
     * @param string $uuid
     * @return bool
     */
    public function deleteUser(string $user_id): bool
    {
        $user = $this->getUserById($user_id);

        if(empty($user)) {
            throw new UserNotFoundException(status: 404, message: 'User not found');
        }

        try {
            DB::beginTransaction();
            $user->delete();
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            throw new DeleteUserException(status: 500, message: 'Failed to delete user');
        }
    }

    /**
     * Get all users
     * @return Collection
     */
    public function getUsers(): Collection
    {
        return $this->user->all();
    }

    /**
     * Get a user by its email
     * @param string $email
     * @return User
     */
    public function getUserByEmail(string $email): ?User
    {
        try {
            $user = $this->user->where('email', $email)->first();
            return $user;
        } catch (Exception $e) {
            throw new UserNotFoundException(status: 404, message: 'User not found');
        }
    }

    /**
     * Add a role to a user
     * @param User $user
     * @param Role $role
     * 
     * @return bool
     */
    public function addRoleToUser(User $user, Role $role): bool
    {
        try {
            $user->roles()->attach($role);
            return true;
        } catch (Exception $e) {
            throw new AddRoleToUserException(status: 500, message: 'Failed to add role to user');
        }
    }

    /**
     * Remove a role from a user
     * @param User $user
     * @param Role $role
     * 
     * @return bool
     */
    public function removeRoleFromUser(User $user, Role $role): bool
    {
        try {
            $user->roles()->detach($role);
            return true;
        } catch (Exception $e) {
            throw new RemoveRoleFromUserException(status: 500, message: 'Failed to remove role from user');
        }
    }
}