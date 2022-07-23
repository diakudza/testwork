<?php

namespace App\Controllers\Validate;

use Rakit\Validation\Validator;

class LoginValidateClass extends ValidateClass
{
    public function validate()
    {
        $validated = $this->validator->validate($_POST, ['name' => 'required|email', 'password' => 'required|min:3']);
        if ($validated->fails()) {
            return 'Введенное значение не валидно!';
        };
        return $validated->getValidData();
    }

}