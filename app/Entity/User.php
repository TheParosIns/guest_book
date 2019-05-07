<?php
/**
 * Created by PhpStorm.
 * User: ina
 * Date: 5/7/19
 * Time: 2:11 PM
 */

class User
{
    protected $id;

    protected $name;

    protected $surname;

    protected $password;

    protected $createdAt;

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getSurname()
    {
        return $this->surname;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function validatePassword($password)
    {

    }
}