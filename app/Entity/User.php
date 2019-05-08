<?php
/**
 * Created by PhpStorm.
 * User: ina
 * Date: 5/7/19
 * Time: 2:11 PM
 */
require_once(__DIR__ . '/../Repository/UserRepository.php');
require_once(__DIR__ . '/../../tools/Sanitaze.php');
require_once(__DIR__ . '/../../config/config.php');

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


    public function verifyPasswords($password, $userPassword)
    {
        $options = [
            'memory_cost' => Config::$PASSWORD_ARGON2_DEFAULT_MEMORY_COST,
            'time_cost' => Config::$PASSWORD_ARGON2_DEFAULT_TIME_COST,
            'threads' => Config::$PASSWORD_ARGON2_DEFAULT_THREADS,
        ];
        //first we verify stored hash against plain-text password
        if (password_verify($password, $userPassword)) {
            // verify legacy password to new password_hash options
            if (password_needs_rehash($userPassword, PASSWORD_ARGON2I, $options)) {
                $newhash = password_hash($password, PASSWORD_ARGON2I, $options);
                // store new hash in db.
                $this->updateUserPassword($newhash);
            }
        }

        return password_verify($password, $userPassword) ? true : false;
    }

}
