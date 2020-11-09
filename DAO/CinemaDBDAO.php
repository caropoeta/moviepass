<?php

namespace DAO;

use DAO\Connection;
use Models\Cinema as Cinema;
use PDOException;

class CinemaDBDAO
{

  private $connection;
  private $tablename = "cinemas";

  public function __construct()
  {
    $this->connection = null;
  }

  public static function getCinemasFromMovie(int $idMov)
  {
    $query = "
    select idCinema from (
      select functions.idRoom, functions.idMovie
      from functions 
      inner join (
        select idFunction , count(*) as asists from tickets group by tickets.idFunction
      ) as asistsPerFunction
      on asistsPerFunction.idFunction = functions.id
      inner join (
        select idRoom, capacity from rooms group by idRoom
      ) as SeatsPerFunction
      on SeatsPerFunction.idRoom = functions.idRoom
      where (capacity - asists) > 0
      and functions.deleted = 0
      ) as idRoomWithSeats
      inner join (
        select rooms.idCinema, rooms.idRoom from rooms
      ) as roomAndCinema
      on idRoomWithSeats.idRoom = roomAndCinema.idRoom
      where idMovie = :idMov
      group by idCinema
      ";
    $param = [];
    $param['idMov'] = $idMov;

    try {
      $conection = Connection::GetInstance();
      $response = $conection->Execute($query, $param);
    } catch (PDOException $th) {
      throw $th;
    }

    return $roleArray = array_map(function (array $obj) {
      return CinemaDBDAO::Read($obj['idCinema']); 
    }, $response);
  }

  public function ReadAll()
  {

    $sql = "SELECT * FROM cinemas 

  where Cinemadelete=0";



    try {
      $this->connection = Connection::getInstance();
      $resultSet = $this->connection->Execute($sql);
      if (!empty($resultSet))
        return $this->Mapear($resultSet);
      else
        return false;
    } catch (PDOException $e) {
      echo $e;
    }
  }

  protected static function Mapear($value)
  {
    $cinemaList = array();
    foreach ($value as $v) {
      $cinema = new Cinema();


      $cinema->setnameCinema($v['cinemaName']);
      $cinema->setAddress($v['address']);
      $cinema->setOpeningTime($v['openingTime']);
      $cinema->setClosingTime($v['closingTime']);
      $cinema->setTicketValue($v['ticket_value']);
      $cinema->setCapacity($v['capacity']);
      $cinema->setidCinema($v['idCinema']);

      array_push($cinemaList, $cinema);
    }
    if (count($cinemaList) > 0)
      return $cinemaList;
    else
      return false;
  }


  public function Add($cinema)
  {
    // Guardo como string la consulta sql utilizando como value, marcadores de parámetros con name (:name) o signos de interrogación (?) por los cuales los valores reales serán sustituidCinemaos cuando la sentencia sea ejecutada 

    $sql = "INSERT INTO cinemas (cinemaName,address,openingTime,closingTime,ticket_value,capacity,Cinemadelete)VALUES (:cinemaName, :address,:openingTime,:closingTime,:ticket_value,:capacity,:Cinemadelete );";


    $parameters['cinemaName'] = $cinema->getnameCinema();
    $parameters['address'] = $cinema->getaddress();
    $parameters['openingTime'] = $cinema->getopeningTime();
    $parameters['closingTime'] = $cinema->getclosingTime();
    $parameters['ticket_value'] = $cinema->getticketValue();
    $parameters['capacity'] = $cinema->getcapacity();
    $parameters['Cinemadelete'] = 0;

    try {
      $this->connection = Connection::getInstance();


      $this->connection->ExecuteNonQuery($sql, $parameters);
    } catch (PDOException $e) {
      echo $e;
    }
  }

  public function Remove($idCinema)
  {

    $sql = "update cinemas
  set cinemaDelete= 1

  WHERE idCinema= :idCinema";

    $parameters['idCinema'] = $idCinema;

    try {
      $this->connection = Connection::getInstance();
      return $this->connection->ExecuteNonQuery($sql, $parameters);
    } catch (PDOException $e) {

      echo $e;
    }
  }

  public function Update(Cinema $cinemaToUpdate)
  {

    $sql = "UPDATE cinemas 
s
  SET cinemaName= :cineName,
  address= :address,
  openingTime=:openingTime,
  closingTime=:closingTime,
  ticket_value=:ticket_value ,

  capacity=:capacity

  WHERE idCinema = :idCinema ";

    $parameters = [];
    $parameters['idCinema'] = $cinemaToUpdate->getidCinema();
    $parameters['cinemaName'] = $cinemaToUpdate->getnameCinema();
    $parameters['address'] = $cinemaToUpdate->getaddress();
    $parameters['openingTime'] = $cinemaToUpdate->getopeningTime();
    $parameters['closingTime'] = $cinemaToUpdate->getclosingTime();
    $parameters['ticket_value'] = $cinemaToUpdate->getticketValue();
    $parameters['capacity'] = $cinemaToUpdate->getcapacity();


    try {
      $this->connection = Connection::getInstance();
      return $this->connection->ExecuteNonQuery($sql, $parameters);
    } catch (PDOException $e) {

      echo $e;
    }
  }
  public static function Read($idCinema)
  {
    $sql = "SELECT 
  * FROM cinemas
  where idCinema = :idCinema";
    $parameters['idCinema'] = $idCinema;
    try {
      $connection = Connection::getInstance();
      $resultSet = $connection->execute($sql, $parameters);
      if (!empty($resultSet)) {
        $result = CinemaDBDAO::mapear($resultSet);
        $cinema = new Cinema();
        $cinema->setnameCinema($result[0]->getnameCinema());
        $cinema->setaddress($result[0]->getaddress());
        $cinema->setopeningTime($result[0]->getopeningTime());
        $cinema->setclosingTime($result[0]->getclosingTime());
        $cinema->setticketValue($result[0]->getticketValue());
        $cinema->setcapacity($result[0]->getcapacity());
        $cinema->setidCinema($result[0]->getidCinema());
        $cinema->setdeleteCinema($result[0] = 0);
        return $cinema;
      } else
        return false;
    } catch (PDOException $e) {
      echo $e;
    }
  }
}
