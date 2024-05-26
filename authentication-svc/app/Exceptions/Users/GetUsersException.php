<?php

namespace App\Exceptions\Users;

use Exception;

class GetUsersException extends Exception
{
    public function __construct($message, $status = 500)
    {
        parent::__construct($message, $status);
    }
}