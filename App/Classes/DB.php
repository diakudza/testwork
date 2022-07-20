<?php

namespace App\Classes;

use PDO;
use PDOException;

class DB
{
    static function on()
    {
        try {
            $connect_str = DB_DRIVER . ':host=' . DB_HOST . ';charset=utf8;dbname=' . DB_NAME;
            $con = new PDO($connect_str, DB_USER, DB_PASS);
            $con->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            return $con;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    static function Insert($table, $object)
    {
        $columns = array();
        foreach ($object as $key => $value) {
            $columns[] = $key;
            $masks[] = ":$key";
            if ($value === null) {
                $object[$key] = 'NULL';
            }
        }

        $columns_s = implode(',', $columns);//"'title','price'"
        $masks_s = implode(',', $masks);//"'title','price'"
        $query = "INSERT INTO $table ($columns_s) VALUES ($masks_s)";
        $q = self::on()->prepare($query);
        $q->execute($object);

        if ($q->errorCode() != PDO::ERR_NONE) {
            $info = $q->errorInfo();
            die($info[2]);
        }

        // return self::Insert()->lastInsertId();
    }

    static public function Update($table, $object, $where)
    {

        $sets = array();

        foreach ($object as $key => $value) {

            $sets[] = "$key=:$key";

            if ($value === NULL) {
                $object[$key] = 'NULL';
            }
        }

        $sets_s = implode(',', $sets);
        $query = "UPDATE $table SET $sets_s WHERE $where";

        $q = self::on()->prepare($query);
        $q->execute($object);

        if ($q->errorCode() != PDO::ERR_NONE) {
            $info = $q->errorInfo();
            die($info[2]);
        }
        return $q->rowCount();
    }

//    static public Query($query)
//    {

}
