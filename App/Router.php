<?php

namespace App;

use App\Exceptions\Exc404;
use App\Models\Model;
use Exception;

class Router
{
    static function start()
    {
        $controller_name = 'Main';
        $action_name = 'index';
        $id = null;
        $routes = explode('/', $_SERVER['REQUEST_URI']);

        if (!empty($routes[1]))
            $controller_name = ucfirst($routes[1]);
        if (!empty($routes[2]))
            $action_name = $routes[2];
        if (!empty($routes[3]))
            $id = $routes[3];
        $method = $_SERVER['REQUEST_METHOD'];
        $modelWithNameSpace = BASE_SPACE . MODELS_SPACE .  $controller_name . 'Model';
        if (file_exists(__DIR__ . "/Models/" . $controller_name . 'Model.php')) {
            $model = new $modelWithNameSpace;
        }

        if (file_exists(__DIR__ . "/Controllers/" . $controller_name . 'Controller.php')) {
            try {
                $controller_name = $controller_name . 'Controller';
                $action_name = 'action_' . $action_name;
                $controller_file = BASE_SPACE . CONTROLLERS_SPACE . $controller_name;
                $controller = new $controller_file($model, $method);
                $controller->$action_name();
            } catch (Exception $e) {
                echo "что-то пошло не так";
            }
        } else {
            throw new Exc404();
        }

//            Route::ErrorPage404();
//        }
//        session_start();
//        $_SESSION['login'] = isset($_SESSION['login'])?$_SESSION['login']:'guest';
//        $_SESSION['role'] = isset($_SESSION['role'])?$_SESSION['role']:'guest';


//        $controller = new \App\Controllers\MainController();
//
//
//
//        $action = $action_name;
//
//        //model::historyAdd($_SESSION['login'],$_SERVER['REQUEST_URI']); // тут вызываю статический метод пишуший в базу последние uri (Не знаю, верное ли решение, но как сделать иначе - не придумал)
//
//        if(method_exists($controller, $action))
//        {
//            $controller->$action($id);
//        }
//        else
//        {
//            Router::ErrorPage404();
//        }
//
//    }
//
//    static function ErrorPage404()
//    {
//        $host = 'http://'.$_SERVER['HTTP_HOST'].'/';
////        header('HTTP/1.1 404 Not Found');
////        header("Status: 404 Not Found");
////        header('Location:'.$host.'404');
    }

}