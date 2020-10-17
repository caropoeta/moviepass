<?php
namespace Models;

	class Cinema{
		private $name;
		private $adress; 
		private $openingTime;
		private $closingTime;
		private $ticketValue;
		private $capacity;
		private $id;

		public function __construct()
		{
		}

		public function setName($name){
			$this->name=$name;
		}

		public function getName(){
			return $this->name;
		}

		public function setAdress($adress){
			$this->adress=$adress;
		}

		public function getAdress(){
			return $this->adress;
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

		public function setCapacity($capacity){
			$this->capacity=$capacity;
		}

		public function getCapacity(){
			return $this->capacity;
		}


		public function setId($id){
			$this->id=$id;
		}

		public function getId(){
			return $this->id;
		}


	}
	?>
