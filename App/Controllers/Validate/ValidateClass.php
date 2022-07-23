<?php

namespace App\Controllers\Validate;

use Rakit\Validation\Validator;

class ValidateClass
{
    public Validator $validator;

    public function __construct()
    {
        $this->validator = new Validator;
    }

}