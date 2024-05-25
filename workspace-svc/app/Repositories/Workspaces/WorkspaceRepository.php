<?php

namespace App\Repositories\Workspaces;

use App\Models\Workspace;
use App\Interfaces\Repositories\WorkspaceRepositoryInterface;
use Illuminate\Support\Facades\DB;
use App\Exceptions\Workspaces\CreateWorkspaceException;
use App\Exceptions\Workspaces\WorkspaceNotFoundException;
use Illuminate\Support\Collection;
class WorkspaceRepository implements WorkspaceRepositoryInterface
{
    public function __construct(
        private readonly Workspace $workspace
    ) {}

    /**
     * Create a new workspace
     * @param Workspace $data
     * @return Workspace
     * @throws CreateWorkspaceException
     */
    public function createWorkspace(Workspace $workspace): Workspace
    {
        try {
            DB::beginTransaction();
            $workspace = $this->workspace->create($workspace->toArray());
            DB::commit();
            return $workspace;
        } catch (Exception $e) {
            DB::rollBack();
            throw new CreateWorkspaceException(status: 500, message: 'Failed to create workspace');
        }
    }

    /**
     * Get a workspace by its ID
     * @param string $id
     * @return Workspace
     * @throws WorkspaceNotFoundException
     */
    public function getWorkspaceById(string $id): Workspace
    {
        $workspace = $this->workspace->find($id);
        if (empty($workspace)) {
            throw new WorkspaceNotFoundException(status: 404, message: 'Workspace not found');
        }
        return $workspace;
    }

    /**
     * Update a workspace
     * @param Workspace $data
     * @return bool
     * @throws UpdateWorkspaceException
     */
    public function updateWorkspace(Workspace $workspace): bool
    {
        try {
            DB::beginTransaction();
            $workspace->save();
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            throw new updateWorkspaceException(status: 500, message: 'Failed to update workspace');
        }
    }
    
    /**
     * Delete a workspace
     * @param string $id
     * @return bool
     * @throws DeleteWorkspaceException
     * @throws WorkspaceNotFoundException
     */

    public function deleteWorkspace(string $id): bool
    {
        $workspace = $this->getWorkspaceById($id);
        if(empty($workspace) ) {
            throw new WorkspaceNotFoundException(status: 404, message: 'Workspace not found');
        }

        try {
            DB::beginTransaction();
            $workspace->delete();
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            throw new DeleteWorkspaceException(status: 500, message: 'Failed to delete workspace');
        }
    }

    /**
     * Get all workspaces
     * @return Collection
     */
    public function getWorkspaces(): Collection
    {
        return $this->workspace->all();
    }


    public function getWorkspaceByEndpoint(string $endpoint): Workspace|null
    {
        return $this->workspace->where('endpoint', $endpoint)->first();
    }
}