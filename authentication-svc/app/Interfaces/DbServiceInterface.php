<?php

namespace App\Interfaces;

interface DbServiceInterface 
{   
    /**
     * Check if the database exists
     * @param string $database
     * @return bool
     */
    public function doesDatabaseExist(string $database): bool;

    /**
     * Create and drop database
     * @param string $database
     * @return bool
     */
    public function createDatabase(string $database): bool;

    /**
     * Drop the database
     * @param string $database
     * @return bool
     */
    public function dropDatabase(string $database): bool;

    /**
     * Changes the database connection of the application
     * @param string $database
     * @return void
     */
    public function setDatabaseConnection(string $database): bool;

    /**
     * Migrate the database
     * Runs Artisan migrate command
     */
    public function migrateDatabase(): bool;
    
    /**
     * Get the database slug
     * @param string $workspace_uuid
     * @return string
     */
    public function getDatabaseSlug(string $workspace_uuid): string;
}