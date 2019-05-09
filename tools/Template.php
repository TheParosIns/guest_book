<?php
/**
 * Created by PhpStorm.
 * User: inakacidhe
 * Date: 19-05-07
 * Time: 9.29.MD
 */

class Template
{
    public static function render_php($path,array $arguments = []){
        extract($arguments, EXTR_SKIP);
        require_once(__DIR__."/../app/Templates/".$path);//pass parameters to the view
        die;
    }

    public static function redirectTo($url = "", $errorMessage= null,$successMessage = null){
        if ($errorMessage != null){ $_SESSION['error'] = $errorMessage;};
        if ($successMessage != null){ $_SESSION['success'] = $successMessage;};
        header("Location: ".$url);
        die();
    }
}
