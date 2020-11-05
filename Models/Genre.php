<?php

namespace Models;

use Exception;

class Genre
{
    private $id;
    private $description;

    public function __construct(int $id, String $name)
    {
        $this->setId($id);
        $this->setDescription($name);
    }

    public static function fromArray(array $obj)
    {
        try {
            return new Genre(
                (string)    $obj["id"],
                (string)    $obj["name"]
            );
        } catch (Exception $ex) {
            return null;
        }
    }
    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;
    }
    public function getDescription()
    {
        return $this->description;
    }
    public function setDescription($description)
    {
        $this->description = $description;
    }
}
