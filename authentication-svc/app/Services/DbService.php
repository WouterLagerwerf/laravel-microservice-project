<?php

namespace App\Services;

use App\Interfaces\DbServiceInterface;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;

class DbService implements DbServiceInterface
{
    /**
     * Check if the database exists
     * @param string $database
     * @return bool
     */
    public function doesDatabaseExist(string $database): bool
    {
        $query = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$database'";

        $result = DB::connection('mysql_without_db')->select($query);
                
        // if the database does not exist, create it
        if (empty($result))
        {
            return false;
        }

        return true;
    }

    /**
     * Create and drop database
     * @param string $database
     * @return bool
     */
    public function createDatabase(string $database): bool
    {
        try {
            DB::connection('mysql_without_db')->statement("CREATE DATABASE $database");
            return true;
        } catch (QueryException $e) {
            return false;
        }
    }

    /**
     * Drop the database
     * @param string $database
     * @return bool
     */
    public function dropDatabase(string $database): bool
    {
        try {
            DB::connection('mysql_without_db')->statement("DROP DATABASE $database");
            return true;
        } catch (QueryException $e) {
            return false;
        }
    }

    /**
     * Changes the database connection of the application
     * @param string $database
     * @return void
     */
    public function setDatabaseConnection(string $database): bool
    {
        try {
            Config::set('database.connections.mysql.database', $database);
            return true;
        } catch (QueryException $e) {
            return false;
        }
    }

    /**
     * Migrate the database
     * Runs Artisan migrate command
     */
    public function migrateDatabase(): bool
    {
        try {
            Artisan::call('migrate');
            return true;
        } catch (QueryException $e) {
            return false;
        }
    }

    /**
     * Get the database slug
     * @param string $workspace_uuid
     * @return string
     */
    public function getDatabaseSlug(string $workspace_uuid): string
    {
        return Str::slug('authentication_workspace_' . $workspace_uuid, '_');
    }
}
