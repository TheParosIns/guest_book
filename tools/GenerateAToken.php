<?php
/**
 * Created by PhpStorm.
 * User: ina
 * Date: 5/8/19
 * Time: 4:05 PM
 */

class GenerateAToken
{

    public static function generateATokenSession($email,$password){
       $_SESSION['token'] = base64_encode ($email.$password);
    }
}