<?php

namespace App\Classes;

use App\Classes\DB;
use App\Exceptions\ExcSessionTimeOut;
use PDOException;


class User
{
    protected $cred;
    protected $token;

    public function __construct(array $cred)
    {
        $this->cred = $cred;
    }

    public function login($q, $startSession = false)
    {
        $user = new User([
            'name' => $q['name'],
            'email' => $q['email'],
            'id' => $q['user_id'],
            'session_start' => $q['session_start'],
        ]);
        if ($startSession) {
            $q = DB::on()->prepare('UPDATE Users SET session_start = :now WHERE user_id = :id');
            $q->execute([
                "id" => $user->cred['id'],
                "now" => date('Y-m-d H:i:s')
            ]);
            setcookie("name", $user->cred['email'], time() + SESSION_TIMEOUT, '/');
        }
        session_start();
        $_SESSION['session_start'] = $user->cred['session_start'];
        $_SESSION['name'] = $user->cred['email'];
        return $user;
    }

    public function loginFromCookie($name)
    {
        $q = DB::on()->prepare("SELECT * FROM Users WHERE email = :email");
        $q->execute(['email' => $name]);
        $q = $q->fetch();
        if ($q['email'] == $name) {
            self::login($q, false);
        }
    }

    public function registrationNewUser($name, $password)
    {
        $password = password_hash($password, PASSWORD_BCRYPT);
        $q = DB::on()->prepare("INSERT INTO Users (email, password) VALUES ( :email, :password)");
        $q->execute([
            'email' => $name,
            'password' => $password]);
        $q = DB::on()->prepare("SELECT * FROM Users WHERE email = :email");
        $q->execute(['email' => $name]);
        $q = $q->fetch();
        return self::login($q, true);
    }

    public function loginFromRequest($name, $password)
    {
        $q = DB::on()->prepare("SELECT * FROM Users WHERE email = :email");
        $q->execute(['email' => $name]);
        $q = $q->fetch();
        if ($name == $q['email']) {
            if (password_verify($password, $q['password'])) {
                return self::login($q, true);
            }
        } else {
            self::registrationNewUser($name, $password);
        }
    }


    public function logout()
    {
        session_start();

        if (isset($_SESSION['name'])) {
            session_unset();
            session_destroy();
        }
        if (isset($_COOKIE['name']) && isset($_COOKIE['name']) != '') {
            setcookie("name", "", time() - 3600, '/');
        }
    }

    public function checkSessionExpired()
    {
        if ($_SESSION['session_start']) {
            if ((strtotime($_SESSION['session_start']) + SESSION_TIMEOUT) - time() < 0) {
                self::logout();
                throw new ExcSessionTimeOut();
            }
        }
    }
}