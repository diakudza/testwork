<?php

namespace App\Classes;

use App\Controllers\Validate\UploadValidateClass;

class PhotoClass
{
    public function getArrayOfPhoto(): array
    {
        $q = DB::on()->prepare('SELECT * FROM Photo WHERE has_thumb = 1 ORDER BY show_count DESC ');
        $q->execute();
        return $q->fetchAll();
    }

    public function getPhotoById(int $id)
    {
        $q = DB::on()->prepare(
            'SELECT photo_id, file_name, email, show_count,server_file_name, Photo.created_at  FROM Photo 
                    LEFT JOIN Users on Photo.user_id = Users.user_id
                    WHERE photo_id = :id');
        $q->execute(['id' => $id]);
        return $q->fetch();
    }

    public function generateThumbs()
    {
        $q = DB::on()->prepare('SELECT photo_id,server_file_name FROM Photo WHERE has_thumb = 0');
        $q->execute();
        foreach ($q->fetchAll() as $item) {
            $image = new ThumbClass(BASE_DIR . '/Storage/image/' . $item['server_file_name']);
            $image->resize(100, 0);
            $image->save(BASE_DIR . '/Storage/image/thumbs/' . $item['server_file_name']);
            $q = DB::on()->exec("UPDATE Photo SET has_thumb = 1 WHERE photo_id = {$item['photo_id']}");
        }
    }

    public function incCountByPhotoId($id)
    {
        $q = DB::on()->prepare('UPDATE Photo SET show_count = show_count + 1  WHERE photo_id = :id');
        $q->execute(['id' => $id]);
        return $q->fetch();
    }

    public function validateAndSave()
    {
        $validate = new UploadValidateClass();
        if ($validate->validate() !== true) {
            return $validate->validate();
        }
        $localFileName = hash('md2', time()) . strrchr($_FILES['photo']['name'], '.');
        if (move_uploaded_file($_FILES['photo']['tmp_name'], BASE_DIR . '/Storage/image/' . $localFileName)) {
            $q = DB::on()->prepare('INSERT INTO Photo (file_name, user_id, server_file_name) VALUES (:file_name , :user_id, :server_name)');
            $q->execute([
                'file_name' => $_FILES['photo']['name'],
                'user_id' => $_SESSION['user_id'],
                'server_name' => $localFileName,
            ]);
            return true;
        }
    }
}
