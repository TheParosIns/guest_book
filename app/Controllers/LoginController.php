<?php
/**
 * Created by PhpStorm.
 * User: ina
 * Date: 5/7/19
 * Time: 2:00 PM
 */
require_once(__DIR__ . '/../../app/Entity/User.php');

class LoginController extends User
{

    public function loginUser()
    {
        //make some input datas validations
        $foundErrors = $this->validateDatas();
        if (count($foundErrors) > 0) {
            RenderView::render_php('login.php', array('foundErrors' => $foundErrors));
        }

        //check if user exist
        $user = new User();
        $checkIfUserExist = $user->findOneByEmail(Sanitaze::sanitazeInput($_POST['email']));
        if (count($checkIfUserExist) > 0) {
            $verifyPasswords = $user->verifyPasswords($_POST["password"], $user->getPassword());
            var_dump($verifyPasswords);
        } else {
            $foundErrors[] = ["error" => "Nope...We didn't find you!...Please check your credentials or if you do not have an account create one ;)"];
            RenderView::render_php('login.php', array('foundErrors' => $foundErrors));
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
}
