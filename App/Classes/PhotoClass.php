<?php

namespace App\Classes;

class PhotoClass
{
    public function getArrayOfPhoto() : Array
    {
        $q = DB::on()->prepare('SELECT * FROM pictures');
        $q->execute();
        var_dump($q->fetchAll());
        return $q->fetchAll();
    }

}