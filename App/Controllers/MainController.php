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
            $photo = new PhotoClass();
            $photo->generateThumbs();
            $this->view->generate('index',
                [
                    'name' => $_COOKIE['name'] ?? $_SESSION['name'],
                    'message' => $_SESSION['message'],
                    'photo' => $photo->getArrayOfPhoto()
                ]);
            unset($_SESSION['message']);
        } else {
            $message = $_SESSION['alert'] ?? "Доступ к главной странице доступем после авторизации";
            $this->view->generate('LoginForm', ['alert' => $message]);
            unset($_SESSION['alert']);
        }
    }
}