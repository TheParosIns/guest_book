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


    public static function build_pdo_query($string, $array) {
        //Get the key lengths for each of the array elements.
        $keys = array_map('strlen', array_keys($array));

        //Sort the array by string length so the longest strings are replaced first.
        array_multisort($keys, SORT_DESC, $array);

        foreach($array as $k => $v) {
            //Quote non-numeric values.
            $replacement = is_numeric($v) ? $v : "'{$v}'";

            //Replace the needle.
            $string = str_replace($k, $replacement, $string);
        }

        return $string;
    }

}
