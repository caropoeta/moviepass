<?php
namespace Models;

class Cinema{
	private $nameCinema;
	private $address; 
	private $openingTime;
	private $closingTime;
	private $ticketValue;
	private $capacity;
	private $idCinema;
	private $deleteCinema;

	public function __construct()
	{
	}

	public function setnameCinema($nameCinema){
		$this->nameCinema=$nameCinema;
	}

	public function getnameCinema(){
		return $this->nameCinema;
	}

	public function setaddress($address){
		$this->address=$address;
	}

	public function getaddress(){
		return $this->address;
	}
	public function setopeningTime($openingTime){
		$this->openingTime=$openingTime;
	}

	public function getopeningTime(){
		return $this->openingTime;
	}
	public function setclosingTime($closingTime){
		$this->closingTime=$closingTime;
	}

	public function getclosingTime(){
		return $this->closingTime;
	}

	public function setticketValue($ticketValue){
		$this->ticketValue=$ticketValue;
	}

	public function getticketValue(){
		return $this->ticketValue;
	}

	public function setcapacity($capacity){
		$this->capacity=$capacity;
	}

	public function getcapacity(){
		return $this->capacity;
	}

	public function setidCinema($idCinema){
		$this->idCinema=$idCinema;
	}

	public function getidCinema(){
		return $this->idCinema;
	}

	public function setdeleteCinema($deleteCinema){
		$this->deleteCinema=$deleteCinema;
	}

	public function getdeleteCinema(){
		return $this->deleteCinema;
	}

}

?>

