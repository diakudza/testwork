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
        $_SESSION['user_id'] = $user->cred['id'];
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
        $q = DB::on()->prepare("UPDATE Users SET session_start = null WHERE user_id = :user_id");
        $q->execute(['user_id' => $_SESSION['user_id']]);
        session_start();
        if (isset($_SESSION['name'])) {
            session_unset();
            session_destroy();
        }
        if (isset($_COOKIE['name']) && isset($_COOKIE['name']) != '') {
            setcookie("name", "", time() - 3600, '/');
        }
    }

    public function redirectIfNoAuth($message)
    {
        session_start();
        if (!isset($_COOKIE['name']) || !isset($_SESSION['name'])) {
            Redirect::to('', $message);
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

    public function checkIsUserComment($user_id, $comment_id)
    {
        if ($user_id != $comment_id) {
            Redirect::back('вы не можете удалить чужой комментарий');
        }
    }

    public function checkTimeForEditComment($user_id, $comment_id)
    {
        $q = DB::on()->prepare("SELECT created_at FROM Comments WHERE comment_id = :id AND user_id = :user_id");
        $q->execute([
            'id' => $comment_id,
            'user_id' => $user_id,
        ]);
        $q = $q->fetch();
        if ((strtotime($q['created_at']) + 60 * 5) - time() < 0) {
            Redirect::back('Редактирование комментариев доступно только втечении 5 минут');
        }
    }

    public function checkTimeForUploadPhoto(int $user_id, string $file)
    {
        $q = DB::on()->prepare("SELECT file_name, created_at FROM Photo WHERE file_name = :file_name AND user_id = :user_id ORDER BY created_at DESC ");
        $q->execute([
            'file_name' => $file,
            'user_id' => $user_id,
        ]);
        $q = $q->fetch();

        if ((strtotime($q['created_at']) + 60 * 3) - time() < 0) {
            if ($q['file_name'] == $file && (strtotime($q['created_at']) + 60 * 15) - time() < 0) {
                Redirect::back('Добавление одинаковых изображений доступно раз в 15 минуты');
            }
        } else {
            Redirect::back('Добавление изображений доступно раз в 3 минуты');
        }
    }

}