<?php
/**
 * Created by PhpStorm.
 * User: ina
 * Date: 5/7/19
 * Time: 2:11 PM
 */
require_once (__DIR__.'/../Repository/UserRepository.php');

class User extends UserRepository
{
    protected $id;

    protected $name;

    protected $surname;

    protected $email;

    protected $password;

    protected $createdAt;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * @param mixed $surname
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
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

    public function verifyPasswords($password,$userPassword){
        $hash=password_hash($userPassword, PASSWORD_ARGON2I, ['memory_cost' => 2048, 'time_cost' => 4, 'threads' => 3]);
       return password_verify($password, $hash) ? true : false;
    }

}
