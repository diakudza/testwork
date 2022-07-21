<?php

namespace App\Controllers;

use App\Classes\Redirect;
use App\Classes\User;
use App\Controllers\Validate\LoginValidateClass;
use http\Header;

class LoginController extends Controller
{
    public function action_index()
    {
        $this->view->generate('LoginForm');
    }
    public function action_signin()
    {
        $validator = new LoginValidateClass();
        $validated = $validator->validate();

        if (isset($_COOKIE["name"])) {
            User::loginFromCookie($_COOKIE["name"]);
        }

        if ( !isset($validated['name'])) {
            $this->view->generate('LoginForm',['message' => 'Введенное значение не валидно!']);
        } else {
            $user = User::loginFromRequest($validated['name'],$validated['password']);
            Redirect::to('',"вы вошли!");
        }
    }

    public function action_signout()
    {

        User::logout();
        Redirect::to();
        $this->view->generate("index");
    }
}