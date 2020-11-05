<?php

namespace Models;

class Functions
{
	private $idFunction;
	private $time;
	private $day;
	private $asistencia;
	private $deleteFunction;

	private $Movie;
	private $idRoom;

	private $finishtime;

	public function __construct()
	{
	}

	public function setidFunction($idFunction)
	{
		$this->idFunction = $idFunction;
	}

	public function getidFunction()
	{
		return $this->idFunction;
	}

	public function setidRoom($idRoom)
	{
		$this->idRoom = $idRoom;
	}

	public function getidRoom()
	{
		return $this->idRoom;
	}

	public function setMovie(Movie $Movie)
	{
		$this->Movie = $Movie;
	}

	public function getMovie()
	{
		return $this->Movie;
	}

	public function setfinishTime($finishtime)
	{
		$this->finishtime = $finishtime;
	}

	public function getfinishTime()
	{
		return $this->finishtime;
	}

	public function setDay(String $day)
	{
		$this->day = $day;
	}

	public function getDay()
	{
		return $this->day;
	}
	public function setTime($time)
	{
		$this->time = $time;
	}

	public function getTime()
	{
		return $this->time;
	}
	public function setAsistencia($asistencia)
	{
		$this->asistencia = $asistencia;
	}

	public function getAsistencia()
	{
		return $this->asistencia;
	}
	public function setDeleteFunction($deleteFunction)
	{
		$this->deleteFunction = $deleteFunction;
	}

	public function getDeleteFunction()
	{
		return $this->deleteFunction;
	}
}
