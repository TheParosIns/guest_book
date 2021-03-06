<?php
/**
 * Created by PhpStorm.
 * User: ina
 * Date: 5/7/19
 * Time: 2:00 PM
 */
require_once(__DIR__ . '/../../app/Entity/User.php');
require_once(__DIR__ . '/../../tools/GenerateAToken.php');

class LoginController extends User
{

    public function showLoginForm(){
        Template::render_php('login.php', array());
    }

    public function loginUser()
    {
        //make some input datas validations
        $foundErrors = $this->validateDatas();
        if (count($foundErrors) > 0) {
            Template::render_php('login.php', array('foundErrors' => $foundErrors));
        }
        //check if user exist
        $user = new User();
        $checkIfUserExist = $user->findOneByEmail(Sanitaze::sanitazeInput($_POST['email']));
        if (count($checkIfUserExist) > 0 && $user->verifyPasswords($_POST["password"], $checkIfUserExist[0]['password'])) {

            $this->updateLoginAttempts($checkIfUserExist[0]['email'],false,0);

            GenerateAToken::generateATokenSession($_POST['email']);
            $_SESSION['user'] = $checkIfUserExist;
            unset($_SESSION["user"][0]["password"]);
            unset($_SESSION["user"][0][4]);
            Template::redirectTo('/guestBook');
        } elseif (count($checkIfUserExist) > 0 && !$user->verifyPasswords($_POST["password"], $checkIfUserExist[0]['password'])) {

            $this->updateLoginAttempts($checkIfUserExist[0]['email'], true,intval($checkIfUserExist[0]['failed_attempts']));
            $response = $this->canNotStillMakeRequests($checkIfUserExist);

            Template::redirectTo('/auth/login', $response['msg']);

        } else {
            Template::redirectTo('/auth/login', "Nope...We didn't find you!...Please check your credentials or if you do not have an account create one ");
        }
    }

    public function validateDatas()
    {
        $errors = [];
        if (strlen($_POST["email"]) < 2) {
            $errors[] = ["field" => "email", "error" => "Email is required."];
        } elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            $errors[] = ["field" => "email", "error" => "Email address is not in a valid format."];
        }
        $password = filter_var($_POST["password"], FILTER_SANITIZE_STRING);
        if (strlen($password) < 8) {
            $errors[] = ["field" => "password", "error" => "Password is at least 8 characters."];
        }
        return $errors;
    }

    public function logout(){
        Session::logout();
        Template::redirectTo('/auth/login');
    }
}
