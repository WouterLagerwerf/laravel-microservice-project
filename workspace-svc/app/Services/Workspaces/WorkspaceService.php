<?php

namespace App\Services\Workspaces;
use App\Interfaces\Services\WorkspaceServiceInterface;
use App\Repositories\Workspaces\WorkspaceRepository;
use App\DTOs\Workspaces\CreateWorkspaceDTO;
use App\DTOs\Workspaces\UpdateWorkspaceDTO;
use App\DTOs\Workspaces\WorkspaceDTO;
use App\Exceptions\Workspaces\WorkspaceAlreadyExistsException;
use App\Exceptions\Workspaces\CreateWorkspaceException;
use Illuminate\Support\Str;
use App\Jobs\Workspaces\CreateWorkspaceEvent;

class WorkspaceService implements WorkspaceServiceInterface
{
    public function __construct(
        private readonly WorkspaceRepository $workspaceRepository
    ) {}

    /** 
     * Create a new workspace
     * @param CreateWorkspaceDTO $dto
     * @return WorkspaceDTO
     * @throws WorkspaceAlreadyExistsException
     * @throws CreateWorkspaceException
     */
    public function createWorkspace(CreateWorkspaceDTO $dto): WorkspaceDTO
    {
        $workspace = $dto->toModel();
        $endpoint = $this->generateEndpoint($workspace->name);

        if ($this->workspaceRepository->getWorkspaceByEndpoint($endpoint)) {
            throw new WorkspaceAlreadyExistsException(status: 409, message: 'Workspace already exists');
        }

        $workspace->endpoint = $endpoint;
        try {
            $workspace = $this->workspaceRepository->createWorkspace($workspace);
        } catch (Exception $e) {
            throw new CreateWorkspaceException(status: 500, message: 'Failed to create workspace');
        }

        // make sure the workspace is created in the authentication microservice, later to be altered to check all microservice
        if (! $workspace->auth_schema_created) {
            CreateWorkspaceEvent::dispatch($workspace->toArray());
        }

        return WorkspaceDTO::fromModel($workspace);
    }

    /** 
     * Update a workspace
     * @param UpdateWorkspaceDTO $dto
     * @return WorkspaceDTO
     * @throws \App\Exceptions\WorkspaceNotFoundException
     */
    public function updateWorkspace(UpdateWorkspaceDTO $dto): WorkspaceDTO
    {
        $workspace = $this->workspaceRepository->getWorkspaceById($dto->uuid);

        if (empty($workspace)) {
            throw new WorkspaceNotFoundException(status: 404, message: 'Workspace not found');
        }

        $workspace->fill($dto->toArray());
        try {
            $this->workspaceRepository->updateWorkspace($workspace);
        } catch (Exception $e) {
            throw new UpdateWorkspaceException(status: 500, message: 'Failed to update workspace');
        }
        return WorkspaceDTO::fromModel($workspace);
    }

    /**
     * Delete a workspace
     * @param string $id
     * @throws \App\Exceptions\WorkspaceNotFoundException
     */
    public function deleteWorkspace(string $id): bool
    {
        $workspace = $this->workspaceRepository->getWorkspaceById($id);

        if (empty($workspace)) {
            throw new WorkspaceNotFoundException(status: 404, message: 'Workspace not found');
        }
        try {
            return $this->workspaceRepository->deleteWorkspace($id);
        } catch (Exception $e) {
            throw new DeleteWorkspaceException(status: 500, message: 'Failed to delete workspace');
        }
    }

    /** 
     * Get a workspace by its ID
     * @param string $id
     * @return WorkspaceDTO
     */
    public function getWorkspaceById(string $id): WorkspaceDTO
    {
        $workspace = $this->workspaceRepository->getWorkspaceById($id);
        if ( empty($workspace)) {
            throw new WorkspaceNotFoundException(status: 404, message: 'Workspace not found');
        }

        return WorkspaceDTO::fromModel($workspace);
    }

    /**
     * Get all workspaces
     * @return array
     */
    public function getWorkspaces(): array
    {
        try {
            return $this->workspaceRepository
                ->getWorkspaces()
                ->map(fn ($workspace) => WorkspaceDTO::fromModel($workspace))
                ->toArray();
        } catch (Exception $e) {
            throw new WorkspaceNotFoundException(status: 404, message: 'Failed to get workspaces');
        }
    }

    public function generateEndpoint(string $name): string
    {
        return Str::slug($name);
    }
}