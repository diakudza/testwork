<?php

namespace App\Controllers\Validate;

use Rakit\Validation\Validator;

class UploadValidateClass extends ValidateClass
{
    public function validate()
    {
        $validated = $this->validator->validate($_FILES, [
            'photo' => 'required|uploaded_file|min:0.25M|max:5M|mimes:gif,png,jpeg',
        ]);

        if ($validated->fails()) {
            return $validated->errors()->firstOfAll();
        };

        return true;
    }

}