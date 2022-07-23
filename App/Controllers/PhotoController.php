<?php

namespace App\Controllers;

use App\Classes\CommentClass;
use App\Classes\PhotoClass;
use App\Classes\User;

class PhotoController extends Controller
{
    function action_show()
    {
        User::redirectIfNoAuth('Доступ к фото, только для зарегистрированных пользователей');
        $photo = new PhotoClass();
        $comments = new CommentClass();
        session_start();
        $this->view->generate('PhotoShow',
            [
                'photo' => $photo->getPhotoById((int)$this->parametrs),
                'comments' => $comments->getCommentsByPhotoId((int)$this->parametrs),
                'user' => $_SESSION['user_id'],
                'message'=> $_SESSION['message']
            ]);
        $photo->incCountByPhotoId((int)$this->parametrs);
        unset($_SESSION['message']);
    }
}