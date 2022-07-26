<?php

namespace App\Classes;

class Redirect
{
    public $message;

    public function __construct($message = null)
    {
        $this->message = $message;
    }

    public static function to($url = '', $message = null)
    {
        if ($message) {
            session_start();
            $_SESSION['message'] = $message;
        }
        $host = 'http://' . $_SERVER['HTTP_HOST'] . '/';
        header('Location:' . $host . $url);
        exit();
    }

    public function back($message = null)
    {
        session_start();
        $_SESSION['message'] = $message;
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }
}