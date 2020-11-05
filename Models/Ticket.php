<?php

namespace Models;

class Ticket
{
	private $id;
	private $seat;
    private $qr;
    private $functionId;
    
    public function setId(int $var)
    {
        $this->idv = $var;
    }

    public function setFunctionId(int $var)
    {
        $this->functionId = $var;
    }

    public function setSeat(int $var)
    {
        $this->seat = $var;
    }

    public function setQr(String $var)
    {
        $this->qr = $var;
    }

    public function getId(int $var)
    {
        return $this->id;
    }

    public function getSeat(int $var)
    {
        return $this->seat;
    }

    public function getQr(String $var)
    {
        return $this->qr;
    }
    
    public function getFunctionId()
    {
        return $this->functionId;
    }
}
