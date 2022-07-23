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
            $this->model->generateThumbs();
            $this->view->generate('PageIndex',
                [
                    'name' => $_COOKIE['name'] ?? $_SESSION['name'],
                    'message' => $_SESSION['message'],
                    'photo' =>  $this->model->getArrayOfPhoto()
                ]);
            unset($_SESSION['message']);
        } else {
            $message = $_SESSION['alert'] ?? "Доступ к главной странице, только для авторизованных пользователей";
            $this->view->generate('PageLoginForm', ['alert' => $message]);
            unset($_SESSION['alert']);
        }
    }
}