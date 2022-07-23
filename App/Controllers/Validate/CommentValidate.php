<?php

namespace App\Controllers\Validate;

class CommentValidate extends ValidateClass
{
    public function validate()
    {
        $validated = $this->validator->validate($_POST, ['text' => 'required|max:50']);
        if ($validated->fails()) {
            return 'Введенное значение не валидно!';
        }
        return $validated->getValidData();
    }

    public function checkForStopWords(string $sting, array $arr = ['лес', 'поляна', 'озеро'])
    {
        $str = preg_replace('/[^a-zA-Zа-яА-Я ]/iu', '', $sting);
        $stringToArray = array_map('strtolower', explode(" ", $str));
        foreach ($stringToArray as $word) {
            if (in_array(mb_strtolower($word), $arr))  {
                return true;
            }
        }
    }
}