<?php

namespace Models;

use Exception;

class CreditCard
{
    private $issuer;
    private $number;

    public static function fromArray(array $obj)
    {
        try {
            $objToRtrn = new CreditCard();
            $objToRtrn->setIssuer($obj["company"]);
            $objToRtrn->setNumber($obj["number"]);
            return $objToRtrn;
        } catch (Exception $ex) {
            return null;
        }
    }
    public function getNumber()
    {
        return $this->number;
    }
    public function setNumber($number)
    {
        $this->number = $number;
    }
    public function getIssuer()
    {
        return $this->issuer;
    }
    public function setIssuer($issuer)
    {
        $this->issuer = $issuer;
    }
}
