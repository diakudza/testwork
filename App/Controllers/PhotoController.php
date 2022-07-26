<?php

namespace App\Controllers;

use App\Classes\CommentClass;
//use App\Classes\PhotoClass;
use App\Classes\Redirect;
use App\Classes\User;

class PhotoController extends Controller
{
    public function action_show()
    {
        User::redirectIfNoAuth('Доступ к фото, только для зарегистрированных пользователей');
        $comments = new CommentClass();
        session_start();

        $this->view->generate('PagePhotoShow',
            [
                'photo' => $this->model->getPhotoById((int)$this->parametrs),
                'comments' => $comments->getCommentsByPhotoId((int)$this->parametrs),
                'user' => $_SESSION['user_id'],
                'message'=> $_SESSION['message']
            ]);
        $this->model->incCountByPhotoId((int)$this->parametrs);
        unset($_SESSION['message']);
    }

    public function action_upload()
    {
        User::redirectIfNoAuth('Доступ к фото, только для зарегистрированных пользователей');

        if($_FILES['photo']) {
            USER::checkTimeForUploadPhoto($_SESSION['user_id'], $_FILES['photo']['name']);
            $result = $this->model->validateAndSave();
            if($result === true){
                Redirect::to('', "Вы добавили новое изображение!");
            } else {
                return Redirect::back($result['photo']);
            };
        }
    }
}