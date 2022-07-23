<?php

namespace App;

use App\Classes\User;
use App\Exceptions\Exc404;
use App\Exceptions\ExcSessionTimeOut;
use Exception;

class Router
{
    static function start()
    {
        session_start();
        $controller_name = 'Main';
        $action_name = 'index';
        $id = null;
        $routes = explode('/', $_SERVER['REQUEST_URI']);

        if (!empty($routes[1]))
            $controller_name = ucfirst($routes[1]);
        if (!empty($routes[2]))
            $action_name = $routes[2];
        if (!empty($routes[3]))
            $parametrs = $routes[3];
        $method = $_SERVER['REQUEST_METHOD'];
        $modelWithNameSpace = BASE_SPACE . MODELS_SPACE . $controller_name . 'Model';
        if (file_exists(__DIR__ . "/Models/" . $controller_name . 'Model.php')) {
            $model = new $modelWithNameSpace;
        }

        if (file_exists(__DIR__ . "/Controllers/" . $controller_name . 'Controller.php')) {
            try {
                USER::checkSessionExpired();
                $controller_name = $controller_name . 'Controller';
                $action_name = 'action_' . $action_name;
                $controller_file = BASE_SPACE . CONTROLLERS_SPACE . $controller_name;
                $controller = new $controller_file($model, $parametrs, $method);
                $controller->$action_name();
            } catch (ExcSessionTimeOut $e) {
                echo "таймаут сессии";
            } catch (Exception $e) {
                echo "что-то пошло не так";
            }
        } else {
            throw new Exc404();
        }

    }

}