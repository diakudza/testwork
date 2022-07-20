<?php

namespace App\Controllers\Validate;

use Rakit\Validation\Validator;

class ValidateClass
{
    public $validator;

    public function vaildate()
    {
        $this->validator = new Validator;
    }

}