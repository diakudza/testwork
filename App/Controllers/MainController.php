<?php

namespace App\Controllers;

use App\Classes\PhotoClass;
use App\Models\Model;

class MainController extends Controller
{

    public function action_index()
    {
        session_start();

        if (isset($_COOKIE['name']) || isset($_SESSION['name'])) {

            $arrayOfPhoto = new PhotoClass();

            $this->view->generate('index',
                [
                    'name' => $_COOKIE['name'] ?? $_SESSION['name'],
                    'message' => $_SESSION['message'],
                    'photo' => $arrayOfPhoto->getArrayOfPhoto()
                ]);
            unset($_SESSION['message']);
        } else {
            $message = $_SESSION['message'] ?? "доступ к галавной странице доступем после авторизации";
            $this->view->generate('LoginForm', ['message' => $message]);
            unset($_SESSION['message']);
        }
    }
}