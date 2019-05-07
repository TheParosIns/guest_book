<?php
session_start();
require('config/config.php');
require('app/Controllers/CreateAccountController.php');
require('app/Controllers/LoginController.php');

if (isset($_POST) & !empty($_POST)) {
    if (isset($_POST['form-create_account'])){
        $createAccount = new CreateAccountController();
        $createAccount->createUser();
    }if (isset($_POST['form-login'])){
        $userLogged = LoginController::loginUser();
    }
//    header("Location: app/Controllers/Security.php");
} else {
    header("Location: login.html");
}