<?php

namespace App\Interfaces;

interface ClientServiceInterface 
{   
    /**
     * Create a new client
     * @param string $name
     * @param string $redirect
     * @return bool
     */
    public function createWorkspacePasswordClient(): bool;

    /**
     * Get a client by its UUID
     * @param string $client_uuid
     * @return array
     */
    public function getWorkspacePasswordClient(): array;
}