<?php
/**
 * Created by PhpStorm.
 * User: inakacidhe
 * Date: 19-05-07
 * Time: 10.36.MD
 */

class Sanitaze
{

    public static function sanitazeInput($input)
    {
        $input = trim($input);
        $input = stripslashes($input);
        $input = htmlspecialchars($input);
        $input = filter_var($input,FILTER_SANITIZE_STRING);
        return $input;
    }

    public static function getHashOptions(){
        return $options = [
            'memory_cost' => PASSWORD_ARGON2_DEFAULT_MEMORY_COST,
            'time_cost' => PASSWORD_ARGON2_DEFAULT_TIME_COST,
            'threads' => PASSWORD_ARGON2_DEFAULT_THREADS,
        ];
    }
}
