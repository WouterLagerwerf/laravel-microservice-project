<?php

namespace App\Services;

use App\Interfaces\Services\UserServiceInterface;
use App\DTOs\CreateUserDTO;
use App\DTOs\UpdateUserDTO;
use App\DTOs\UserDTO;
use App\DTOs\AddRoleToUserDTO;
use App\DTOs\RemoveRoleFromUserDTO;
use App\Repositories\UserRepository;
use App\Repositories\RoleRepository;
use App\Exceptions\Users\CreateUserException;
use App\Exceptions\Users\UserAlreadyExistsException;
use App\Exceptions\Users\UserNotFoundException;
use App\Exceptions\Users\UpdateUserException;
use App\Exceptions\Users\DeleteUserException;
use App\Exceptions\Users\GetUsersException;
use App\Exceptions\Roles\RoleNotFoundException;
use App\Exceptions\Roles\AddRoleToUserException;
use App\Exceptions\Roles\RemoveRoleFromUserException;

class UserService implements UserServiceInterface
{
    public function __construct(
        private UserRepository $userRepository,
        private RoleRepository $roleRepository
    ) {}

    /**
     * Create a new user
     * @param CreateUserDTO $dto
     * @return UserDTO
     * @throws CreateUserException
     * @throws UserAlreadyExistsException
     */
    public function createUser(CreateUserDTO $dto): UserDTO
    {
        $user = $dto->toModel();

        if ($this->userRepository->getUserByEmail($user['email'])) {
            throw new UserAlreadyExistsException(status: 400, message: 'User already exists');
        }

        try {
            $user = $this->userRepository->createUser($user);
        } catch (CreateUserException $e) {
            throw new CreateUserException(status: 500, message: 'Failed to create user');
        }

        return UserDTO::fromModel($user);
    }

    /** 
     * Get a user by its ID
     * @param string $user_id
     * @return UserDTO
     * @throws UserNotFoundException
     */
    public function getUserById(string $user_id): UserDTO
    {
        $user = $this->userRepository->getUserById($user_id);

        if (empty($user)) {
            throw new UserNotFoundException(status: 404, message: 'User not found');
        }

        return UserDTO::fromModel($user);
    }

    /** 
     * Update a user
     * @param UpdateUserDTO $dto
     * @return UserDTO
     * @throws UpdateUserException
     * @throws UserNotFoundException
     */
    public function updateUser(UpdateUserDTO $dto): UserDTO
    {
       $user = $this->userRepository->getUserById($dto->uuid);

        if (empty($user)) {
            throw new UserNotFoundException(status: 404, message: 'User not found');
        }

        $user->email = $dto->email;
        $user->name = $dto->name;

        try {
            $user = $this->userRepository->updateUser($user);
        } catch (UpdateUserException $e) {
            throw new UpdateUserException(status: 500, message: 'Failed to update user');
        }

        return UserDTO::fromModel($user);
    }

    /**
     * Delete a user
     * @param string $user_id
     * @return bool
     * @throws DeleteUserException
     * @throws UserNotFoundException
     */
    public function deleteUser(string $user_id): bool
    {
        $user = $this->userRepository->getUserById($user_id);
        if (empty($user)) {
            throw new UserNotFoundException(status: 404, message: 'User not found');
        }

        try {
            return $this->userRepository->deleteUser($user_id);
        } catch (Exception $e) {
            throw new DeleteUserException(status: 500, message: 'Failed to delete user');
        }
    }

    /**
     * Get all users
     * @return array
     * @throws GetUsersException
     */
    public function getUsers(): array
    {
        try {
            $users = $this->userRepository
                ->getUsers()
                ->map(fn ($user) => UserDTO::fromModel($user))
                ->toArray();
        } catch (Exception $e) {
            throw new GetUsersException(status: 500, message: 'Failed to get users');
        }

        return $users;
    }   

    /**
     * Add a role to a user
     * @param AddRoleToUserDTO $dto
     * @return bool
     * @throws UserNotFoundException
     * @throws RoleNotFoundException
     * @throws AddRoleToUserException
     */
    public function addRoleToUser(AddRoleToUserDTO $dto): bool
    {
        $user = $this->userRepository->getUserById($dto->user_id);
        if (empty($user)) {
            throw new UserNotFoundException(status: 404, message: 'User not found');
        }

        $role = $this->roleRepository->getRoleById($dto->role_id);
        if (empty($role)) {
            throw new RoleNotFoundException(status: 404, message: 'Role not found');
        }

        try {
            return $this->userRepository->addRoleToUser($user, $role);
        } catch (Exception $e) {
            throw new AddRoleToUserException(status: 500, message: 'Failed to add role to user');
        }
    }

    /**
     * Remove a role from a user
     * @param RemoveRoleFromUserDTO $dto
     * @return bool
     * @throws UserNotFoundException
     * @throws RoleNotFoundException
     * @throws RemoveRoleFromUserException
     */
    public function removeRoleFromUser(RemoveRoleFromUserDTO $dto): bool
    {
        $user = $this->userRepository->getUserById($dto->user_id);
        if (empty($user)) {
            throw new UserNotFoundException(status: 404, message: 'User not found');
        }

        $role = $this->roleRepository->getRoleById($dto->role_id);
        if (empty($role)) {
            throw new RoleNotFoundException(status: 404, message: 'Role not found');
        }

        try {
            return $this->userRepository->removeRoleFromUser($user, $role);
        } catch (Exception $e) {
            throw new RemoveRoleFromUserException(status: 500, message: 'Failed to remove role from user');
        }
    }

}