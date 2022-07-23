<?php

namespace App\Classes;

use App\Controllers\Validate\CommentValidate;

class CommentClass
{
    public function getCommentsByPhotoId($id)
    {
        $q = DB::on()->prepare(
            'SELECT Comments.user_id, comment_id,photo_id,text,email,Comments.created_at, comment_is_edited 
                    FROM Comments
                    LEFT JOIN Users on Comments.user_id = Users.user_id
                    WHERE photo_id = :id');
        $q->execute(['id' => $id]);
        return $q->fetchAll();
    }
}