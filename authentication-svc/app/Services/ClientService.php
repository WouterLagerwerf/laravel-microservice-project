<?php

namespace App\Services;

use App\Interfaces\Services\ClientServiceInterface;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
 
class ClientService implements ClientServiceInterface
{
    /**
     * Create a new client
     * @param string $name
     * @param string $redirect
     */
    public function createWorkspacePasswordClient(): bool
    {
        try {
            DB::beginTransaction();
            DB::table('oauth_clients')->insert([
                'id' => Str::uuid(),
                'name' => 'Password Grant Client',
                'secret' => Str::random(40),
                'password_client' => 1,
                'personal_access_client' => 0,
                'redirect' => 'http://localhost',
                'revoked' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            DB::commit();
        } catch (QueryException $e) {
            DB::rollBack();
            return false;
        }
        return true;
    }

    /**
     * Get a client by its UUID
     * @param string $client_uuid
     */
    public function getWorkspacePasswordClient(): array
    {
        try {
            return (array) DB::table('oauth_clients')->where('password_client', 1)->first();
        } catch (QueryException $e) {
            return [];
        }
    }
}