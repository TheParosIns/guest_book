<?php
session_start();
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', TRUE);
date_default_timezone_set('Europe/Tirane');
require('../app/Controllers/CreateAccountController.php');
require('../app/Controllers/LoginController.php');
require('../app/Controllers/MessageController.php');
require_once('../tools/RenderView.php');
require_once(__DIR__ . '/../config/config.php');
require_once(__DIR__ . '/../routes.php');

