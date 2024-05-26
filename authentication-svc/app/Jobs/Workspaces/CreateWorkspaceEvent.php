<?php

namespace App\Jobs\Workspaces;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Database\QueryException;
use App\Jobs\Workspaces\CreatedWorkspaceEvent;
use Illuminate\Support\Facades\Log;
use App\Services\DbService;
use App\Services\ClientService;
use App\Exceptions\Workspaces\DatabaseException;

class CreateWorkspaceEvent implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public array $workspace
    ) {}

    /**
     * Execute the job.
     */
    public function handle(DbService $dbService, ClientService $clientService): void
    {
        if (empty($this->workspace)) {
            return;
        }
        $database = $dbService->getDatabaseSlug($this->workspace['endpoint']);
       
        if(! $dbService->doesDatabaseExist($database)) {
            if( ! $dbService->createDatabase($database)) {
                throw new DatabaseException('Database could not be created');
            }

            $dbService->setDatabaseConnection($database);
            $dbService->migrateDatabase();
            $dbService->seedDatabase();
        }
        
        // check if a password client exists 
        $client = $clientService->getWorkspacePasswordClient();

        if (! $client)
        {
            if (! $clientService->createWorkspacePasswordClient())
            {
                throw new DatabaseException('Client could not be created');
            }

            $client = $clientService->getWorkspacePasswordClient();
        }

        $client['workspace_id'] = $this->workspace['uuid'];

        CreatedWorkspaceEvent::dispatch((array) $client);
    }
}
