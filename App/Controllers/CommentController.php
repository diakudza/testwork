<?php

namespace App\Controllers;

use App\Classes\CommentClass;
use App\Classes\PhotoClass;
use App\Classes\Redirect;
use App\Classes\User;
use App\Controllers\Validate\CommentValidate;
use App\Models\Model;

class CommentController extends Controller
{

    public $validator;
    public $comment;


    public function __construct(Model $model = null, string $parametrs = null, string $method = null)
    {
        parent::__construct($model, $parametrs, $method);
        $this->validator = new CommentValidate();
        $this->comment = new CommentClass();
    }

    public function action_add()
    {
        User::redirectIfNoAuth('Доступ к комметариям, только для зарегистрированных пользовелей');
        if ($this->validator->checkForStopWords($_POST['comment_text'])) {
            Redirect::back('У нас запрещены слова: Лес, Поляна, Озеро');
            return;
        }
        $this->comment->addCommentToPhoto((int)$_POST['photo_id'], (int)$_POST['user_id'], $_POST['comment_text'],);
        Redirect::back('Комментарий добавлен');
    }

    public function action_edit()
    {
        session_start();
        User::redirectIfNoAuth('Доступ к комметариям, только для зарегистрированных пользовелей');
        User::checkTimeForEditComment($_SESSION['user_id'], (int)$this->parametrs);
        $this->view->generate('CommentEditForm',
            [
                'comments' => $this->comment->getCommentsById((int)$this->parametrs),
                'user' => $_SESSION['user_id'],
                'message' => $_SESSION['message']
            ]);
    }

    public function action_update()
    {
        User::redirectIfNoAuth('Доступ к комметариям, только для зарегистрированных пользовелей');
        if ($this->validator->checkForStopWords($_POST['comment_text'])) {
            Redirect::back('У нас запрещены слова: Лес, Поляна, Озеро');
            return;
        }
        if ($this->comment->updateComment((int)$_POST['comment_id'], $_POST['comment_text'])) {
            Redirect::to('photo/show/' . $_POST['photo_id'], 'Комментарий обновлен');
        } else {
            Redirect::to('photo/show/' . $_POST['photo_id'],'Ошибка обновления комментарий');
        }

    }

    public function action_delete()
    {
        User::redirectIfNoAuth('Доступ к комметариям, только для зарегистрированных пользовелей');
        $q = $this->comment->deleteCommentById((int)$this->parametrs);
        if (!$q) {
            Redirect::back('Ошибка удаления комментария! Возможно такого комментария уже нет!');
            return;
        }
        Redirect::back('Комментарий удален');
    }

    public function action_history()
    {
        User::redirectIfNoAuth('Доступ к комметариям, только для зарегистрированных пользовелей');

        $this->view->generate('CommentsHistory',
            [
                'comments' => $this->comment->getCommentHistoruById((int)$this->parametrs),
            ]);

    }

}