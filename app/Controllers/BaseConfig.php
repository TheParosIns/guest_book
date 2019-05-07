<?php
/**
 * Created by PhpStorm.
 * User: ina
 * Date: 5/7/19
 * Time: 4:10 PM
 */

require_once (__DIR__.'/../../config/config.php');

class BaseConfig
{

    public static function connect()
    {
        try {
            $conn = new PDO(Config::$dialect . ":host=" . Config::$host . ";dbname=" . Config::$database . "", Config::$user, Config::$password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch (Exception $e) {
            echo $e->getMessage();
        }

    }

}
