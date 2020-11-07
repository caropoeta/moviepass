<?php

namespace Models;

class Ticket
{
	private $id;
	private $seat;
    private $qr;
    private $functionId;
    private $movTitl;
    private $date;
    
    public function setId(int $var)
    {
        $this->idv = $var;
    }

    public function setDate(String $var)
    {
        $this->date = $var;
    }

    public function setMovieTitle(String $var)
    {
        $this->movTitl = $var;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function getMovieTitle()
    {
        return $this->movTitl;
    }

    public function setFunctionName(String $var)
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

    public function getId()
    {
        return $this->id;
    }

    public function getSeat()
    {
        return $this->seat;
    }

    public function getQr()
    {
        return $this->qr;
    }
    
    public function getFunctionName()
    {
        return $this->functionId;
    }
}
