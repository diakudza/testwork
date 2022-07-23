<?php

namespace App\Classes;

class Ctwig
{
static function twig(){
    require $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';
    $loader = new \Twig\Loader\FilesystemLoader('View');
    $twig = new \Twig\Environment($loader, ['debug' => true]);
    $twig->addExtension(new \Twig\Extension\DebugExtension());
    return $twig;
}
}