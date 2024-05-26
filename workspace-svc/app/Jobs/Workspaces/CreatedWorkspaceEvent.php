<?php

namespace App\Jobs\Workspaces;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use App\DTOs\Workspaces\UpdateWorkspaceDTO;
use App\Services\Workspaces\WorkspaceService;
use App\Exceptions\Workspaces\WorkspaceNotFoundException;
use App\Exceptions\Workspaces\UpdateWorkspaceException;

class CreatedWorkspaceEvent implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

     /**
     * Create a new job instance.
     */
    public function __construct(
        public array $client
    ){}

    /**
     * Execute the job.
     */
    public function handle(WorkspaceService $workspaceService)
    {
        if(empty($this->client)) {
            return;
        }

        $workspace = $workspaceService->getWorkspaceById($this->client['workspace_id']);

        if(empty($workspace)) {
            throw new WorkspaceNotFoundException(status: 404, message: 'Workspace not found');
            return;
        }

        $workspace = new UpdateWorkspaceDTO(
            uuid: $workspace->id,
            name: $workspace->name,
            auth_schema_created: true,
            password_client_id: encrypt($this->client['id']),
            password_client_secret: encrypt($this->client['secret'])
        );

        if (empty($workspaceService->updateWorkspace($workspace))) {
            throw new UpdateWorkspaceException(status: 500, message: 'Failed to update workspace');
        }
    }
}
