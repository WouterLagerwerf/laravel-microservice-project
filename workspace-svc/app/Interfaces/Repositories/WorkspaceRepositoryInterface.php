<?php

namespace App\Interfaces\Repositories;

use App\Models\Workspace;
use Illuminate\Support\Collection;

interface WorkspaceRepositoryInterface
{
    /**
     * Create a new workspace
     * @param Workspace $workspace
     * @return Workspace
     * @throws CreateWorkspaceException
     */
    public function createWorkspace(Workspace $workspace): Workspace;

    /**
     * Get a workspace by its ID
     * @param string $id
     * @return Workspace
     * @throws WorkspaceNotFoundException
     */
    public function getWorkspaceById(string $id): Workspace;

    /**
     * Update a workspace
     * @param Workspace $workspace
     * @return bool
     * @throws UpdateWorkspaceException
     */
    public function updateWorkspace(Workspace $workspace): bool;

    /**
     * Delete a workspace
     * @param string $id
     * @return bool
     * @throws DeleteWorkspaceException
     */
    public function deleteWorkspace(string $id): bool;

    /**
     * Get all workspaces
     * @return Collection
     */
    public function getWorkspaces(): Collection;

    /**
     * Get a workspace by its endpoint
     * @param string $endpoint
     * @return Workspace|null
     */
    public function getWorkspaceByEndpoint(string $endpoint): Workspace|null;
}
