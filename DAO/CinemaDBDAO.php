<?php
namespace DAO;
use DAO\Connection;
use \PDO as PDO;
use \Exception as Exception;
use DAO\QueryType as QueryType;
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


public function ReadAll(){

  $sql = "SELECT * FROM cinemas 
  where deleteCinema=0";

  try
  {
    $this->connection = Connection::getInstance();
    $resultSet = $this->connection->Execute($sql);
    if (!empty($resultSet))
      return $this->Mapear($resultSet);
    else 
     return false; 
 }

 catch(PDOException $e)

 {
  echo $e;
}

}  

protected function Mapear($value) 
{
  $cinemaList = array();
  foreach($value as $v){
    $cinema = new Cinema();

    $cinema->setNameCinema($v['nameCinema']);
    $cinema->setAddress($v['address']);
    $cinema->setOpeningTime($v['openingTime']);
    $cinema->setClosingTime($v['closingTime']);
    $cinema->setTicketValue($v['ticketValue']);
    $cinema->setCapacity($v['capacity']);
    $cinema->setIdCinema($v['idCinema']);

    array_push($cinemaList,$cinema);
  }
  if(count($cinemaList)>0)
    return $cinemaList;
  else
    return false;
}

public function Add(Cinema $cinema){
      // Guardo como string la consulta sql utilizando como value, marcadores de parámetros con name (:name) o signos de interrogación (?) por los cuales los valores reales serán sustituidCinemaos cuando la sentencia sea ejecutada 

  $sql = "INSERT INTO cinemas (nameCinema,address,openingTime,closingTime,ticketValue,capacity,deleteCinema)VALUES (:nameCinema, :address,:openingTime,:closingTime,:ticketValue,:capacity,:deleteCinema );";

  $parameters['nameCinema'] = $cinema->getNameCinema();
  $parameters['address']=$cinema->getAddress();
  $parameters['openingTime']=$cinema->getOpeningTime();
  $parameters['closingTime']=$cinema->getClosingTime();
  $parameters['ticketValue'] = $cinema->getTicketValue();
  $parameters['capacity'] = $cinema->getCapacity();
  $parameters['deleteCinema']=(int)$cinema->getDeleteCinema();

  try
  {
    $this->connection = Connection::getInstance();

    
    $this->connection->ExecuteNonQuery($sql, $parameters);

  }
  catch(PDOException $e)
  {
    echo $e;
  }
}

public function Remove($idCinema){

  $sql = "update cinemas
  set deleteCinema= 1
  WHERE idCinema= :idCinema";

  $parameters['idCinema'] = $idCinema;

  try{
    $this->connection = Connection::getInstance();
    return $this->connection->ExecuteNonQuery($sql, $parameters);
  }

  catch(PDOException $e){

    echo $e;
  }
}
public function Update(Cinema $cinemaToUpdate){

  $sql="UPDATE cinemas 
  SET nameCinema= :nameCinema,
  address= :address,
  openingTime=:openingTime,
  closingTime=:closingTime,
  ticketValue=:ticketValue ,
  capacity=:capacity

  WHERE idCinema = :idCinema ";
  $parameters=[];  
  $parameters['idCinema']=$cinemaToUpdate->getIdCinema();
  $parameters['nameCinema'] = $cinemaToUpdate->getNameCinema();
  $parameters['address']=$cinemaToUpdate->getAddress();
  $parameters['openingTime']=$cinemaToUpdate->getOpeningTime();
  $parameters['closingTime']=$cinemaToUpdate->getClosingTime();
  $parameters['ticketValue'] = $cinemaToUpdate->getTicketValue();
  $parameters['capacity']=$cinemaToUpdate->getCapacity();


  try{
    $this->connection = Connection::getInstance();
    return $this->connection->ExecuteNonQuery($sql, $parameters);
  }

  catch(PDOException $e){

    echo $e;
  }
}
public function Read ($idCinema)
{
  $sql = "SELECT 
  * FROM cinemas
  where idCinema = :idCinema";
  $parameters['idCinema'] = $idCinema;
  try
  {
    $this->connection = Connection::getInstance();
    $resultSet = $this->connection->execute($sql, $parameters);
    if(!empty($resultSet))
    {
     $result = $this->mapear($resultSet);
     $cinema = new Cinema();
     $cinema->setNameCinema($result[0]->getNameCinema());
     $cinema->setAddress($result[0]->getAddress());
     $cinema->setOpeningTime($result[0]->getOpeningTime());
     $cinema->setClosingTime($result[0]->getClosingTime());
     $cinema->setTicketValue($result[0]->getTicketValue()); 
     $cinema->setCapacity($result[0]->getCapacity());
     $cinema->setIdCinema($result[0]->getIdCinema());
     return $cinema;  

   }else
   return false;
 }

 catch(PDOException $e)

 {
  echo $e;
}

}
}

