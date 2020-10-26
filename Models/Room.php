<?php

namespace Models;

use Exception;

class Room
{
    private $id;
    private $name;
    private $price;
    private $capacity;
    private $cinema;

    public static function fromArray(array $obj)
    {
        try {
            return new Room(
                (int)    $obj["idRoom"],
                (int)    $obj["roomName"],
                (float)  $obj["price"],
                (string)  $obj["capacity"],
                (int)  $obj["cinema"]
            );
        } catch (Exception $ex) {
            return NULL;
        }
    }
    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setCapacity($capacity)
    {
        $this->capacity = $capacity;
    }

    public function getCapacity()
    {
        return $this->capacity;
    }

    public function setCinema($cinema)
    {
        $this->cinema = $cinema;
    }

    public function getCinema()
    {
        return $this->cinema;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }

    public function getPrice()
    {
        return $this->price;
    }
   
}
