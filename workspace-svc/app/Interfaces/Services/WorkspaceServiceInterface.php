<?php

namespace App\Interfaces\Services;
use App\DTOs\Workspaces\WorkspaceDTO;
use App\DTOs\Workspaces\CreateWorkspaceDTO;
use App\DTOs\Workspaces\UpdateWorkspaceDTO;
use App\Exceptions\Workspaces\WorkspaceAlreadyExistsException;
use App\Exceptions\Workspaces\CreateWorkspaceException;

interface WorkspaceServiceInterface
{
    /**
     * Create a new workspace
     * @param CreateWorkspaceDTO $dto
     * @return WorkspaceDTO
     * @throws WorkspaceAlreadyExistsException
     * @throws CreateWorkspaceException
     */
    public function createWorkspace(CreateWorkspaceDTO $dto): WorkspaceDTO;
    /** 
     * Update a workspace
     * @param UpdateWorkspaceDTO $dto
     * @return WorkspaceDTO
     * @throws \App\Exceptions\WorkspaceNotFoundException
     */
    public function updateWorkspace(UpdateWorkspaceDTO $dto): WorkspaceDTO;

    /**
     * Delete a workspace
     * @param string $id
     * @return bool
     * @throws \App\Exceptions\WorkspaceNotFoundException
     */
    public function deleteWorkspace(string $id): bool;
    
    /** 
     * Get a workspace by its ID
     * @param string $id
     * @return WorkspaceDTO
     */
    public function getWorkspaceById(string $id): WorkspaceDTO;

    /**
     * Get all workspaces
     * @return array
     */
    public function getWorkspaces(): array;

    /**
     * Generate an endpoint for a workspace by converting the name into a slug
     * @param string $name
     * @return string
     */
    public function generateEndpoint(string $name): string;
}
