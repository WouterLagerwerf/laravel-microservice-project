<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Database\QueryException;
class ValidateDB extends Command
{
     /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:check-and-create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check if the database provided in DB_DATABASE exists, and create it if it doesn\'t';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // check if the database exists
        $database = Config::get('database.connections.mysql.database');
        $query = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$database'";
        $result = DB::connection('mysql_without_db')->select($query);
        
        // if the database does not exist, create it
        if (empty($result))
        {
            $this->info("Database does not exist. Creating it now...");
            $query = "CREATE DATABASE $database";
            try {
                DB::connection('mysql_without_db')->statement($query);
                $this->info("Database created successfully.");
            } catch (QueryException $e) {
                $this->error("Error creating database: " . $e->getMessage());
            }
        } else {
            $this->info("Database exists.");
        }
       
        // call the migrate command
        $this->call('migrate');

        return 0;
    }
}
