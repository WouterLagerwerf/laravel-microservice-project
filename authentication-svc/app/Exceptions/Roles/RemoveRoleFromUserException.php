<?php

namespace App\Exceptions\Roles;

use Exception;

class RemoveRoleFromUserException extends Exception
{
    public function __construct($message, $status = 500)
    {
        parent::__construct($message, $status);
    }
}