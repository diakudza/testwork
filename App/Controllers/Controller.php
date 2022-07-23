<?php

namespace App\Controllers;

use App\Classes\View;
use App\Models\Model;

class Controller
{
    public $model;
    public $view;
    public $parametrs;
    public $method;

    public function __construct(Model $model = null, string $parametrs = null, string $method = null)
    {
        $this->view = new View();
        $this->model = $model;
        $this->method = $method;
        $this->parametrs = $parametrs;
    }

    function action_index()
    {

    }
}