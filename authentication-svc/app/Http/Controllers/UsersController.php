<?php

namespace App\Http\Controllers;

use App\DTOs\UserDTO;
use App\Services\UserService;
use App\Http\Requests\Users\StoreUserRequest;
use App\Http\Requests\Users\UpdateUserRequest;
use App\Http\Requests\Users\AddRoleToUserRequest;
use App\Http\Requests\Users\RemoveRoleFromUserRequest;
use App\Interfaces\Controllers\UserControllerInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Exceptions\Users\UserNotFoundException;
use App\Exceptions\Users\UserAlreadyExistsException;
use App\Exceptions\Users\CreateUserException;
use App\DTOs\CreateUserDTO;
use App\DTOs\UpdateUserDTO;
use App\DTOs\AddRoleToUserDTO;
use App\DTOs\RemoveRoleFromUserDTO;

class UsersController extends Controller implements UserControllerInterface
{
    public function __construct(
        private readonly UserService $userService
    ) {}
    
    /**
     * Display a listing of all users.
     */
    public function index(StoreUserRequest $request, string $workspace_endpoint): JsonResponse
    {
        $users = $this->userService->getUsers();
        
        if (count($users) === 0) {
            return response()->json(['message' => 'No users found'], 404);
        }

        return response()->json($users, 200);
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(StoreUserRequest $request, string $workspace_endpoint): JsonResponse
    {
        $dto = CreateUserDTO::fromRequest($request->validated());
        try {
            $user = $this->userService->createUser($dto);
        } catch (UserAlreadyExistsException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        } catch (CreateUserException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        } catch (UserNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }
        return response()->json($user, 201);
    }

    /**
     * Display the specified user.
     */
    public function show(Request $request, string $workspace_endpoint, string $id): JsonResponse
    {
        try {
            $user = $this->userService->getUserById($id);
        } catch (UserNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }
        return response()->json($user, 200);
    }

    /**
     * Update the specified user in storage.
     */
    public function update(UpdateUserRequest $request, string $workspace_endpoint, string $id): JsonResponse
    {
        $dto = UpdateUserDTO::fromRequest($request->validated());
        $dto->uuid = $id;
        
        try {
            $user = $this->userService->updateUser($dto, $id);
        } catch (UserNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }
        return response()->json($user, 200);
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(string $workspace_endpoint, string $id): JsonResponse
    {
        try {
            $this->userService->deleteUser($id);
        } catch (UserNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }
        return response()->json(['message' => 'User deleted'], 200);
    }

    /**
     * Add a role to the specified user.
     */
    public function addRole(AddRoleToUserRequest $request, string $workspace_endpoint, string $id): JsonResponse
    {
        $dto = AddRoleToUserDTO::fromRequest($request->validated());
        $dto->user_uuid = $id;
        
        try {
            $user = $this->userService->addRoleToUser($dto);
        } catch (UserNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }
        return response()->json($user, 200);
    }

    /**
     * Remove a role from the specified user.
     */
    public function removeRole(RemoveRoleFromUserRequest $request, string $workspace_endpoint, string $id): JsonResponse
    {
        $dto = RemoveRoleFromUserDTO::fromRequest($request->validated());
        $dto->user_uuid = $id;
        
        try {
            $user = $this->userService->removeRoleFromUser($dto);
        } catch (UserNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }
        return response()->json($user, 200);
    }
}
