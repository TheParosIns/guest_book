<?php
/**
 * Created by PhpStorm.
 * User: ina
 * Date: 5/9/19
 * Time: 1:56 PM
 */

$uriRaw = $_SERVER["REQUEST_URI"];
$uriExploded = explode("/", $uriRaw);
$module = isset($uriExploded[1]) ? $uriExploded[1] : "";
$controller = isset($uriExploded[2]) ? $uriExploded[2] : "";
$action = isset($uriExploded[3]) ? $uriExploded[3] : "";
$idParameter = isset($uriExploded[4]) ? $uriExploded[4] : "";

//Routes
// / GET  Show landing page.
// auth/register GET   Show registration form.
// auth/register/send POST  Submit registration form.
// auth/login GET Show login form.
// auth/login/send POST Submit login form.
// guestBook/ GET Show a listing of all guest book notes.
// guestBook/note/new GET Show note creation form.
// guestBook/note/create POST Submit note creation form.
// guestBook/note/edit/{noteID} GET Show note editing form.
// guestBook/note/update/{noteID} POST Submit note editing form.
// guestBook/note/view/{noteID} GET Show note and all it"s replies.
// guestBook/note/delete/{noteID} GET Delete note.
// guestBook/reply/{noteID} POST Submit a new reply for a given note.


if (strlen($module) > 0) {
    if ($module == "auth") {
        if ($controller == "register") {
            if ($action == "send") {
               $register = new CreateAccountController();
               $register->createUser();
            } else {
                $register = new CreateAccountController();
                $register->showCreateAccount();
            }
        } elseif ($controller == "login") {
            if ($action == "send") {
                echo "Submit login form.";
            } else {
                $login = new LoginController();
                $login->showLoginForm();
            }
        } else {
            $login = new LoginController();
            $login->showLoginForm();
        }
    } elseif ($module == "guestBook") {
        if ($controller == "note") {
            if ($action == "new") {
                echo "Show note creation form.";
            }
            elseif ($action == "create") {
                echo "Submit note creation form.";
            }
            elseif ($action == "edit") {
                idParameterExists();
                echo "Show note editing form.";
            }
            elseif ($action == "update") {
                idParameterExists();
                echo "Submit note editing form.";
            }
            elseif ($action == "view") {
                idParameterExists();
                echo "Show note and all it's replies.";
            }
            elseif ($action == "delete") {
                idParameterExists();
                echo "Delete note.";
            }
            else {
                returnErrorPage(404);
            }
        } elseif ($controller == "reply") {
            if (idParameterExists()) {
                echo "Submit a new reply for a given note.";
            } else {
                returnErrorPage(404);
            }
        } else {
            echo "Show a listing of all guest book notes.";
        }
    } else {
        returnErrorPage(404);
    }
} else {
    $home = new MessageController();
    $home->showHomePage();
}


function returnErrorPage($errorCode)
{
    switch ($errorCode) {
        case 404:
            $message = "Resource not found.";
            break;
        case 405:
            $message = "Method not allowed.";
            break;
        case 401:
            $message = "Unauthorized.";
            break;
        case 403:
            $message = "Forbidden.";
            break;
        default:
            // Error code 500
            $message = "Server error!";
    }
    http_response_code($errorCode);
    echo  $message;
    //Show error page with respective message;
    die;
}

function idParameterExists()
{
    if (isset($idParameter)) {
        returnErrorPage(404);
    }
    return true;
}

function requestMethodIsValid($type)
{
    if (!$_SERVER["REQUEST_METHOD"] != strtoupper($type)) {
        returnErrorPage(405);
    }
    return true;
}

function isAuthorized(){
    //Check if user is logged in.
}