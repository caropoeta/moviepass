<?php
namespace Models;

class FunctionMovie{

	private $idFunction;
	private $time; 
	private $asistencia;
	private $deleteFunction;

	public function __construct()
	{
	}

	public function setidFunction($idFunction){
		$this->idFunction=$idFunction;
	}

	public function getidFunction(){
		return $this->idFunction;
	}

	public function setTime($time){
		$this->time=$time;
	}

	public function getTime(){
		return $this->time;
	}
	public function setAsistencia($asistencia){
		$this->asistencia=$asistencia;
	}

	public function getAsistencia(){
		return $this->asistencia;
	}
	public function setDeleteFunction($deleteFunction){
		$this->deleteFunction=$deleteFunction;
	}

	public function getDeleteFunction(){
		return $this->deleteFunction;
	}
}
?>

