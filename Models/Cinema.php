<?php
namespace Models;
class Cinema{
private $name;
private $address; 
private $openingTime
private $closingTime
private $ticketValue;
private $id;

public function setName($name){
$this->name=$name;
}

public function getName(){
return $this->name;
}

public function setAddress($address){
$this->address=$address;
}

public function getAddress(){
return $this->address;
}
public function setOpeningTime($openingTime){
$this->openingTime=$openingTime;
}

public function getOpeningTime(){
return $this->openingTime;
}
public function setClosingTime($closingTime){
$this->closingTime=$closingTime;
}

public function getClosingTime(){
return $this->closingTime;
}

public function setTicketValue($ticketValue){
$this->ticketValue=$ticketValue;
}

public function getTicketValue(){
return $this->ticketValue;
}

public function setId($id){
$this->id=$id;
}

public function getId(){
return $this->id;`
}


}
?>
