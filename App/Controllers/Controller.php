<?php

namespace App\Controllers;

use App\Classes\View;
use App\Models\Model;

class Controller
{
    public $model;
    public $view;
    public $method;

    public function __construct(Model $model = null, string $method)
    {
        $this->view = new View();
        $this->model = $model;
        $this->method = $method;
    }

    function action_index()
    {

    }
}