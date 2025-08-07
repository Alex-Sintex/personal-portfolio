<?php

namespace App\Exceptions;

use Exception;

class ModelNotFoundException extends Exception
{
    public function __construct(string $modelClass)
    {
        parent::__construct("Model $modelClass not found");
    }
}
