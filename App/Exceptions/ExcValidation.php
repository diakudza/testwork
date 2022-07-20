<?php

namespace App\Exceptions;

use Exception;
use Rakit\Validation\ErrorBag;

class ExcValidation extends Exception
{
    protected ErrorBag $errors;

    public function __construct(string $msg, ErrorBag $errors)
    {
        parent::__construct($msg);

        $this->errors = $errors;
    }

    public function getBag()
    {
        return $this->errors;
    }
}