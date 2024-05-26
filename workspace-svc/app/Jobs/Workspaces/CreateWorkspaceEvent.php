<?php
namespace App\Jobs\Workspaces;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Workspace;
use Illuminate\Support\Facades\Log;

class CreateWorkspaceEvent implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public array $workspace)
    {
        $this->onConnection('sns');
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        Log::info('From Job: Workspace created', $this->workspace);
    }
}
