<?php 

namespace App\Interfaces\Controllers;
use App\Http\Requests\Users\StoreUserRequest;
use App\Http\Requests\Users\UpdateUserRequest;
use App\Http\Requests\Users\AddRoleToUserRequest;
use App\Http\Requests\Users\RemoveRoleFromUserRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;


interface UserControllerInterface
{
    /**
     * Get a listing of all users.
     * @param StoreUserRequest $request
     * @return JsonResponse
     */
    public function index(StoreUserRequest $request, string $workspace_endpoint): JsonResponse;

    /**
     * Store a newly created user in storage.
     * @param StoreUserRequest $request
     * @return JsonResponse
     */
    public function store(StoreUserRequest $request, string $workspace_endpoint): JsonResponse;

    /**
     * Display the specified user.
     * @param Request $request
     * @param string $id
     * @return JsonResponse
     */
    public function show(Request $request, string $workspace_endpoint, string $id): JsonResponse;

    /**
     * Update the specified user in storage.
     * @param UpdateUserRequest $request
     * @param string $id
     * @return JsonResponse
     */
    public function update(UpdateUserRequest $request, string $workspace_endpoint, string $id): JsonResponse;

    /**
     * Remove the specified user from storage.
     * @param string $id
     * @return JsonResponse
     */
    public function destroy(string $workspace_endpoint, string $id): JsonResponse;

    /**
     * Add a role to the specified user.
     * @param AddRoleToUserRequest $request
     * @param string $id
     * @return JsonResponse
     */
    public function addRole(AddRoleToUserRequest $request, string $workspace_endpoint, string $id): JsonResponse;

    /**
     * Remove a role from the specified user.
     * @param RemoveRoleFromUserRequest $request
     * @param string $id
     * @return JsonResponse
     */
    public function removeRole(RemoveRoleFromUserRequest $request, string $workspace_endpoint, string $id): JsonResponse;
}
