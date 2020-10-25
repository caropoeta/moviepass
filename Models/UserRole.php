<?php

namespace Models;

use Exception;

class UserRole
{
    private $id;
    private $name;

    public function __construct(String $name, int $id)
    {
        $this->setId($id);
        $this->setName($name);
    }

    public static function fromArray(array $obj)
    {
        try {
            return new UserRole(
                (string)    $obj["role_name"],
                (int)       $obj["role_id"]
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

    public function getId()
    {
        return $this->id;
    }
    public function getName()
    {
        return $this->name;
    }
}
