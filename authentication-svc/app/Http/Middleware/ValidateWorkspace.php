<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Services\DbService;
use Cache;
class ValidateWorkspace
{
    public function __construct(
        private readonly DbService $dbService
    ) {}
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $workspaceEndpoint = $request->route('workspace_endpoint');

        $database = $this->dbService->getDatabaseSlug($workspaceEndpoint);

        $databaseExists = Cache::remember('database_exists_'. $database, 500, function () use ($database) {
            return $this->dbService->doesDatabaseExist($database);
        });

        if (! $databaseExists) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $this->dbService->setDatabaseConnection($database);

        return $next($request);
    }
}
