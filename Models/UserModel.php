<?php

namespace Models;

use Exception;

class UserModel
{
    private $id;
    private $name;
    private $password;
    private $role;
    private $dni;
    private $email;
    private $birthday;

    public function __construct(String $name, String $password, String $role, int $dni, String $email, String $birthday, int $id = 0)
    {
        $this->setId($id);
        $this->setName($name);
        $this->setPassword($password);
        $this->setRole($role);
        $this->setDni($dni);
        $this->setEmail($email);
        $this->setBirthday($birthday);
    }

    public static function fromArray(array $obj)
    {
        try {
            return new UserModel(
                (string)    $obj["user_name"],
                (string)    $obj["user_password"],
                (string)    $obj["role_name"],
                (int)       $obj["user_dni"],
                (string)    $obj["user_email"],
                (string)    $obj["user_birthday"],
                (int)       $obj["user_id"]
            );
        } catch (Exception $ex) {
            return null;
        }
    }

    public function setId(int $id_)
    {
        $this->id = $id_;
    }
    public function setName(String $name_)
    {
        $this->name = $name_;
    }
    public function setPassword(String $password_)
    {
        $this->password = $password_;
    }
    public function setRole(String $role_)
    {
        $this->role = $role_;
    }
    public function setDni(int $dni_)
    {
        $this->dni = $dni_;
    }
    public function setEmail(String $email_)
    {
        $this->email = $email_;
    }
    public function setBirthday(String $birthday_)
    {
        $this->birthday = $birthday_;
    }

    public function getId()
    {
        return $this->id;
    }
    public function getName()
    {
        return $this->name;
    }
    public function getPassword()
    {
        return $this->password;
    }
    public function getRole()
    {
        return $this->role;
    }
    public function getDni()
    {
        return $this->dni;
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function getBirthday()
    {
        return $this->birthday;
    }
}
