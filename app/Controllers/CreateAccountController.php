<?php
/**
 * Created by PhpStorm.
 * User: ina
 * Date: 5/7/19
 * Time: 2:00 PM
 */

require_once (__DIR__ . '/BaseConfig.php');

class CreateAccountController extends BaseConfig
{

    public function createUser()
    {
        $foundErrors = $this->validateDatas();
        if (count($foundErrors)> 0){
            header("Location: create_account.php");
        }

    }

    public function validateDatas()
    {

        $errors = [];
        $name = BaseConfig::sanitazeRequestData($_POST["name"]);
        $nameClean = filter_var($name, FILTER_SANITIZE_STRING);
        if (strlen($nameClean) < 2) {
            $errors[] = ["field" => "name", "error" => "Name is too short."];
        } elseif (!preg_match("/^[a-zA-Z'-]+$/", $nameClean)) {
            $errors[] = ["field" => "name", "error" => "Name is not valid. Only characters are allowed."];
        }
        $surname = BaseConfig::sanitazeRequestData($_POST["surname"]);
        $surnameClean = filter_var($surname, FILTER_SANITIZE_STRING);
        if (strlen($surnameClean) < 2) {
            $errors[] = ["field" => "surname", "error" => "Surname is too short."];
        } elseif (!preg_match("/^[a-zA-Z'-]+$/", $surnameClean)) {
            $errors[] = ["field" => "surname", "error" => "Surname is not valid."];
        }
        $emailClean = BaseConfig::sanitazeRequestData($_POST["email"]);
        if (strlen($emailClean) < 2) {
            $errors[] = ["field" => "email", "error" => "Email is required."];
        } elseif (!filter_var($emailClean, FILTER_VALIDATE_EMAIL)) {
            $errors[] = ["field" => "email", "error" => "Email address is not in a valid format."];
        }
        $password = BaseConfig::sanitazeRequestData($_POST["password"]);
        $passwordClean = filter_var($password, FILTER_SANITIZE_STRING);
        $passwordValidationErrors = self::validatePassword($passwordClean);
        if (count($passwordValidationErrors) > 0) {
            $errors[] = ["field" => "password", "error" => implode(" ", $passwordValidationErrors)];
        }

        return $errors;
    }

    public function validatePassword($password)
    {
        $errors = [];
        if (strlen($password) < 8) {
            $errors[] = "The password is too short.A minimum of 8 characters is required.";
        }
        if (!preg_match("#[0-9]+#", $password)) {
            $errors[] = "The password must include at least one number.";
        }
        if (!preg_match("#[a-zA-Z]+#", $password)) {
            $errors[] = "The password  must include at least one letter.";
        }
        return $errors;
    }
}