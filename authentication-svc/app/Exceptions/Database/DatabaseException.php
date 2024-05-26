<?php

namespace App\Exceptions\Database;

use Exception;

class DatabaseException extends Exception
{
    public function __construct($message, $status = 500)
    {
        parent::__construct($message, $status);
    }
}