<?php

namespace App\Classes;

use App\Classes\DB;


class User
{
    protected $cred;
    protected $token;
    protected $SessionExpiredTime;

    public function __construct(array $cred)
    {
        $this->cred = $cred;
    }

    public function login($q)
    {
        $user = new User([
            'name' => $q['name'],
            'email' => $q['email'],
            'id' => $q['user_id'],
            'session_start' => $q['session_start'],
        ]);

        $q = DB::on()->prepare('UPDATE Users SET session_start = :now WHERE user_id = :id');
        $q->execute([
            "id" => $user->cred['id'],
            "now" => date('Y-m-d H:i:s')
        ]);

        session_start();
        $_SESSION['name'] = $user->cred['email'];
        setcookie("name", $user->cred['email'], time() + 3600);
        return $user;
    }

    public function loginFromCookie($name)
    {

        $q = DB::on()->prepare("SELECT * FROM Users WHERE email = :email");
        $q->execute(['email' => $name]);
        $q = $q->fetch();
        if ($q['email'] == $name) {
            self::login($q);
        }
    }

    public function loginFromRequest($name, $password)
    {
        $q = DB::on()->prepare("SELECT * FROM Users WHERE email = :email");
        $q->execute(['email' => $name]);
        $q = $q->fetch();
        if ($name == $q['email']) {
            if (password_verify($password, $q['password'])) {
                self::login($q);
            }
        } else {
            return "нет такого";
        }
    }

    public function logout()
    {
        session_unset();
        session_destroy();
        setcookie("name", "", time() - 3600);
    }

    public function checkSessionExpired(User $user)
    {
//        if ($this->SessionExpiredTime)
    }
}