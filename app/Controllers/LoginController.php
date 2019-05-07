<?php
/**
 * Created by PhpStorm.
 * User: ina
 * Date: 5/7/19
 * Time: 2:00 PM
 */
require_once (__DIR__.'/../../config/config.php');
class LoginController extends BaseConfig
{

    public function loginUser()
    {
        $connect = $this->connect();
        $email = mysqli_real_escape_string($connect, $_POST['email']);
        $password = md5($_POST['password']);

        $sql = "SELECT * FROM `user` WHERE ";
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            $sql .= "email='$email'";
        }
        $sql .= " AND password='$password'";
        $res = mysqli_query($connect, $sql);
        $count = mysqli_num_rows($res);

        if($count == 1){
            $_SESSION['email'] = $email;
            header('location: home/index.php');
        }else{
            echo "User does not exist";
        }
    }

    public function validateDatas()
    {
        $errors = [];
        if (strlen($_POST["email"]) <2){
            $errors[]= ["field"=>"email", "error"=>"Email is required."];
        }elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
            $errors[]= ["field"=>"email", "error"=>"Email address is not in a valid format."];
        }
        $password = filter_var($_POST["password"], FILTER_SANITIZE_STRING);
        if (strlen($password) <8){
            $errors[]= ["field"=>"password", "error"=>"Password is at least 8 characters."];
        }
        return $errors;
    }
}