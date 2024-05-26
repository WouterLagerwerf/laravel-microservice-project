<?php

namespace App\Exceptions\Roles;

use Exception;

class RoleException extends Exception
{
    public function __construct($message, $status = 500)
    {
        parent::__construct($message, $status);
    }
}