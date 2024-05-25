<?php

namespace App\Http\Controllers\Workspaces;

use App\Http\Controllers\Controller;

use App\DTOs\Workspaces\CreateWorkspaceDTO;
use App\DTOs\Workspaces\UpdateWorkspaceDTO;

use App\Services\Workspaces\WorkspaceService;

use App\Http\Requests\Workspaces\StoreWorkspaceRequest;
use App\Http\Requests\Workspaces\UpdateWorkspaceRequest;

use App\Exceptions\Workspaces\WorkspaceNotFoundException;
use App\Exceptions\Workspaces\WorkspaceAlreadyExistsException;
use App\Exceptions\Workspaces\CreateWorkspaceException;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class WorkspaceController extends Controller
{
    public function __construct(
        private readonly WorkspaceService $workspaceService
    ) {}
    /**
     * Display a listing of the workspaces.
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $workspaces = $this->workspaceService->getWorkspaces();

        if(count($workspaces) === 0) {
            return response()->json(['message' => 'No workspaces found'], 404);
        }

        return response()->json($workspaces, 200);
    }

    /**
     * Store a newly created workspace in storage.
     * @param StoreWorkspaceRequest $request
     * @return JsonResponse
     */
    public function store(StoreWorkspaceRequest $request): JsonResponse
    {
        $dto = CreateWorkspaceDTO::fromRequest($request->validated());
        try {
            $workspace = $this->workspaceService->createWorkspace($dto);
        } catch (WorkspaceAlreadyExistsException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        } catch (CreateWorkspaceException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }
        return response()->json($workspace, 201);
    }

    /**
     * get a workspace from storage
     * @param string $id
     * @return JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        try {
            $workspace = $this->workspaceService->getWorkspaceById($id);
        } catch (WorkspaceNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }

        return response()->json($workspace, 200);
    }

    /**
     * Update the specified workspace in storage.
     * @param UpdateWorkspaceRequest $request
     * @param string $id
     * @return JsonResponse
     */
    public function update(UpdateWorkspaceRequest $request, string $id): JsonResponse
    {
        $dto = UpdateWorkspaceDTO::fromRequest($request->validated());
        $dto->uuid = $id;

        try {
            $workspace = $this->workspaceService->updateWorkspace($dto);
        } catch (WorkspaceNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }

        return response()->json($workspace, 200);
    }

    /**
     * Remove the specified workspace from storage.
     * @param string $id
     * @return JsonResponse
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $this->workspaceService->deleteWorkspace($id);
        } catch (WorkspaceNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }

        return response()->json(['message' => 'Workspace deleted'], 204);
    }
}
