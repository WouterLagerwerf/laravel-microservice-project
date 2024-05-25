<?php 

namespace App\Interfaces\Controllers;
use App\Http\Requests\Workspaces\StoreWorkspaceRequest;
use App\Http\Requests\Workspaces\UpdateWorkspaceRequest;
use Illuminate\Http\JsonResponse;

class WorkspaceControllerInterface
{
    /**
     * Display a listing of the workspaces
     * @return JsonResponse
     */
    public function index(): JsonResponse

    /**
     * Store a newly created workspace in storage
     * @param StoreWorkspaceRequest $request
     * @return JsonResponse
     */
    public function store(StoreWorkspaceRequest $request): JsonResponse

    /**
     * return the specified workspace
     * @param string $id
     * @return JsonResponse
     */
    public function show(string $id): JsonResponse

    /**
     * Update the specified workspace in storage
     * @param UpdateWorkspaceRequest $request
     * @param string $id
     */
    public function update(UpdateWorkspaceRequest $request, string $id): JsonResponse

    /**
     * Remove the specified workspace from storage
     * @param string $id
     * @return JsonResponse
     */
    public function destroy(string $id): JsonResponse
}