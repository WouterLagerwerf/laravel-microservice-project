<?php

namespace App\Exceptions\Workspaces;

use Exception;

class UpdateWorkspaceException extends Exception
{
    public function __construct($message, $status = 500)
    {
        parent::__construct($message, $status);
    }
}