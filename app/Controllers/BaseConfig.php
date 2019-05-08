<?php
/**
 * Created by PhpStorm.
 * User: ina
 * Date: 5/7/19
 * Time: 4:10 PM
 */

class BaseConfig
{

    public static function connect()
    {
        try {
            $conn = new PDO(DB_ENGINE . ":host=" . DB_HOST . ";dbname=" . DB_NAME . "", DB_USER, DB_PASSWORD);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch (Exception $e) {
            echo $e->getMessage();
        }

    }

}
