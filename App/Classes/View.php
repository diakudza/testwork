<?php

namespace App\Classes;

class View
{

    function generate($page, $data = null)
    {
        echo Ctwig::twig()->render('base.twig',
            [
                'page' => $page,
                'template' => $page . '.twig',
                'userLogin' => $data['userLogin'] ?? $data['userLogin'] ?? 'guest',
                'data' => $data,
            ]);
    }
}