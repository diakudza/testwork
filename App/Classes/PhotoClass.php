<?php

namespace App\Classes;

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
            'SELECT photo_id, file_name, email, show_count, Photo.created_at  FROM Photo 
                    LEFT JOIN Users on Photo.user_id = Users.user_id
                    WHERE photo_id = :id');
        $q->execute(['id' => $id]);
        return $q->fetch();
    }

    public function generateThumbs()
    {
        $q = DB::on()->prepare('SELECT photo_id,file_name FROM Photo WHERE has_thumb = 0');
        $q->execute();
        foreach ($q->fetchAll() as $item) {
            $image = new ThumbClass(BASE_DIR . '/Storage/image/' . $item['file_name']);
            $image->resize(100, 0);
            $image->save(BASE_DIR . '/Storage/image/thumbs/' . $item['file_name']);
            $q = DB::on()->exec("UPDATE Photo SET has_thumb = 1 WHERE photo_id = {$item['photo_id']}");
        }
    }

    public function incCountByPhotoId($id)    {
        $q = DB::on()->prepare('UPDATE Photo SET show_count = show_count + 1  WHERE photo_id = :id');
        $q->execute(['id' => $id]);
        return $q->fetch();
    }
}
