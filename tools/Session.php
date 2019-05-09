<?php
/**
 * Created by PhpStorm.
 * User: ina
 * Date: 5/9/19
 * Time: 4:48 PM
 */

class Session
{

    public static function isUserLogged(){
        return isset($_SESSION["user"]) && isset($_SESSION["token"]);
    }
}