<?php

namespace App\Controllers;

use App\Models\Model;

class MainController extends Controller
{

    public function action_index()
    {
        if (isset($_COOKIE['name']) !== null) {
            $this->view->generate('index');
        } else {
            $this->view->generate('LoginForm', ['message' => "Доступ только для авторизованных пользоватетлей"]);
        }

    }
}