<?php
namespace Models;

class FilmFunction{
	private $idMovieFunction;
	private $startFunction;
	private $daysOfWeek; 
	private $assistance;
	private $deleteFunction;
	private $idRoom;
	private $idMovie;

	public function __construct()
	{
	}

	public function setIdMovieFunction($idMovieFunction){
		$this->idMovieFunction=$idMovieFunction;
	}

	public function getIdMovieFunction(){
		return $this->idMovieFunction;
	}

	public function setStartFunction($startFunction){
		$this->startFunction=$startFunction;
	}

	public function getStartFunction(){
		return $this->startFunction;
	}
	public function setDaysOfWeek($daysOfWeek){
		$this->daysOfWeek=$daysOfWeek;
	}

	public function getDaysOfWeek(){
		return $this->daysOfWeek;
	}
	public function setAssistance($assistance){
		$this->assistance=$assistance;
	}

	public function getAssistance(){
		return $this->assistance;
	}
	public function setDeleteFunction($deleteFunction){
		$this->deleteFunction=$deleteFunction;
	}

	public function getDeleteFunction(){
		return $this->deleteFunction;
	}
	public function setIdRoom($idRoom){
		$this->idRoom=$idRoom;
	}

	public function getIdRoom(){
		return $this->idRoom;
	}
	public function setIdMovie($idMovie){
		$this->idMovie=$idMovie;
	}

	public function getIdMovie(){
		return $this->idMovie;
	}
}





