<?php

namespace App\Models;

use App\Classes\DB;

class CommentModel extends Model
{

    public function getCommentsById($id)
    {
        $q = DB::on()->prepare(
            'SELECT Comments.user_id, comment_id,photo_id,text,email,Comments.created_at 
                    FROM Comments
                    LEFT JOIN Users on Comments.user_id = Users.user_id
                    WHERE comment_id = :id');
        $q->execute(['id' => $id]);
        return $q->fetchAll();
    }

    public function deleteCommentById(int $comment_id)
    {
        $q = DB::on()->prepare("SELECT comment_id, user_id FROM Comments WHERE comment_id = :id");
        $q->execute(['id' => $comment_id]);
        $q = $q->fetchAll();
        if (!$q) {
            return false;
        }
        $q = DB::on()->prepare(
            'DELETE FROM Comments WHERE comment_id = :id');
        $q->execute(['id' => $comment_id]);
        return true;
    }

    public function updateComment(int $comment_id, string $comment_text)
    {
        $q = DB::on()->prepare("
                        INSERT INTO New_edited_comments (text, parrent_comment)  
                        (SELECT text, comment_id FROM Comments WHERE comment_id = :id) ");
        $q->execute([
            'id' => $comment_id,
        ]);

        $q = DB::on()->prepare("UPDATE Comments SET comment_is_edited = 1, text = :text WHERE comment_id = :id");
        $q->execute([
            'id' => $comment_id,
            'text' => $comment_text,
        ]);
        $q = $q->fetch();
        if ($q) {
            return false;
        }
        return true;
    }

    public function getCommentHistoryById(int $comment_id)
    {
        $q = DB::on()->prepare("
        SELECT * FROM New_edited_comments WHERE parrent_comment = :id");
        $q->execute([
            'id' => $comment_id,
        ]);
        return $q = $q->fetchAll();
    }

    public function addCommentToPhoto(int $photo_id, int $user_id, $text)
    {
        $q = DB::on()->prepare("INSERT INTO Comments ( photo_id, user_id, text) VALUES (:photo_id, :user_id, :text)");
        $q->execute([
            'photo_id' => $photo_id,
            'user_id' => $user_id,
            'text' => $text,
        ]);
        return $q;
    }
}