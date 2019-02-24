<?php
namespace App\Classes;

/**
 * Class Database
 * @package App\Classes
 * @description : Elle se charge de la connection avec la BD.
 */
class Database{
    public static $pdo;

    /***
     * @return \PDO
     */
    public static function getPDO(){
        if(isset(self::$pdo)){
            return self::$pdo;
        }

        self::$pdo = new \PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME, DB_USER, DB_PASSWORD);

        return self::$pdo;
    }
}