<?php
session_start();
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', TRUE);
date_default_timezone_set('Europe/Tirane');
require('config/config.php');
require('app/Controllers/CreateAccountController.php');
require('app/Controllers/LoginController.php');
require_once ('tools/RenderView.php');

if (isset($_POST) & !empty($_POST)) {
    if (isset($_POST['form-create_account']) || isset($_REQUEST['form-create-account'])){
        $createAccount = new CreateAccountController();
        $createAccount->createUser();
    }if (isset($_POST['form-login']) || isset($_REQUEST['form-login'])){
        $userLogged = new LoginController();
        $userLogged->loginUser();
    }
//    header("Location: app/Controllers/Security.php");
} else {
    header("Location: /../app/Templates/login.php");
}
