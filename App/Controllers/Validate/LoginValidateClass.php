<?php

namespace App\Controllers\Validate;

use Rakit\Validation\Validator;

class LoginValidateClass extends ValidateClass
{
    public function validate()
    {
        $validator = new Validator;
        $validated = $validator->validate($_POST, ['name' => 'required|email', 'password' => 'required|min:3']);
        if (!count($validated->getValidData())) {
            return 'Введенное значение не валидно!';
        };
        return $validated->getValidData();
    }

}