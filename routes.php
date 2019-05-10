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
$idMessage = $action;

//Routes
// / GET  Show landing page.
// auth/create_account GET   Show registration form.
// auth/create_account/send POST  Submit registration form.
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

if (Session::isUserLogged()){
    if (strlen($module) > 0) {
      if ($module == "guestBook") {
            if ($controller == "message") {
                if ($action == "new") {
                    $message = new MessageController();
                    $message->sendMessage();
                }
                elseif ($action == "create") {
                    $message = new MessageController();
                    $message->createMessageForm();
                }
                elseif ($action == "edit") {
                    idParameterExists();
                    $message = new MessageController();
                    $message->editMessageForm($idParameter);
                }
                elseif ($action == "update") {
                    idParameterExists();
                    $message = new MessageController();
                    $message->updateMessage($idParameter);
                }
                elseif ($action == "view") {
                    $message = new MessageController();
                    $message->showMessageList();
                }
                elseif ($action == "viewMessage") {
                    idParameterExists();
                    $message = new MessageController();
                    $message->viewMessage($idParameter);
                }
                elseif ($action == "delete") {
                    idParameterExists();
                    $message = new MessageController();
                    $message->deleteMessage($idParameter);
                }
                else {
                    returnErrorPage(404);
                }
            } elseif ($controller == "reply") {
                if (idParameterExists()) {
                    $message = new MessageController();
                    $message->replyMessage($idMessage);
                } else {
                    returnErrorPage(404);
                }
            } else {
                $home = new MessageController();
                $home->showHomePage();
            }
        } elseif ($module == "logout"){
          $logout= new LoginController();
          $logout->logout();
      }
        else {
            returnErrorPage(404);
        }
    } else {
        $home = new MessageController();
        $home->showHomePage();
    }
}else{
    if ($module == "auth") {
        if ($controller == "create_account") {
            if ($action == "send") {
                $create_account = new CreateAccountController();
                $create_account->createAccount();
            } else {
                $create_account = new CreateAccountController();
                $create_account->showCreateAccountForm();
            }
        }
        if($controller == "login") {
            if ($action == "send") {
                $login = new LoginController();
                $login->loginUser();
            } else {
                $login = new LoginController();
                $login->showLoginForm();
            }
        }
    }else{
       Template::redirectTo("/auth/login");
    }
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
