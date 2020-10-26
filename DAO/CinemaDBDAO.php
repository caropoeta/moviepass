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

  where Cinemadelete=0";



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


    $cinema->setnameCinema($v['cinemaName']);
    $cinema->setAddress($v['address']);
    $cinema->setOpeningTime($v['openingTime']);
    $cinema->setClosingTime($v['closingTime']);
    $cinema->setTicketValue($v['ticketValue']);
    $cinema->setCapacity($v['capacity']);
    $cinema->setidCinema($v['idCinema']);

    array_push($cinemaList,$cinema);
  }
  if(count($cinemaList)>0)
    return $cinemaList;
  else
    return false;
}

public function Add(Cinema $cinema){
      // Guardo como string la consulta sql utilizando como value, marcadores de parámetros con name (:name) o signos de interrogación (?) por los cuales los valores reales serán sustituidCinemaos cuando la sentencia sea ejecutada 

  $sql = "INSERT INTO cinemas (cinemaName,address,openingTime,closingTime,ticket_value,capacity,deleteCinema)VALUES (:cinemaName, :address,:openingTime,:closingTime,:ticket_value,:capacity,:deleteCinema );";

  $parameters['cinemaName'] = $cinema->getnameCinema();
  $parameters['address']=$cinema->getaddress();
  $parameters['openingTime']=$cinema->getopeningTime();
  $parameters['closingTime']=$cinema->getclosingTime();
  $parameters['ticket_value'] = $cinema->getticketValue();
  $parameters['capacity'] = $cinema->getcapacity();
  $parameters['Cinemadelete']=0;

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
  set cinemaDelete= 1

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
s
  SET cinemaName= :cineName,
  address= :address,
  openingTime=:openingTime,
  closingTime=:closingTime,
  ticket_value=:ticket_value ,

  capacity=:capacity

  WHERE idCinema = :idCinema ";
  $parameters=[];  
  $parameters['idCinema']=$cinemaToUpdate->getidCinema();
  $parameters['cinemaName'] = $cinemaToUpdate->getnameCinema();
  $parameters['address']=$cinemaToUpdate->getaddress();
  $parameters['openingTime']=$cinemaToUpdate->getopeningTime();
  $parameters['closingTime']=$cinemaToUpdate->getclosingTime();
  $parameters['ticket_value'] = $cinemaToUpdate->getticketValue();
  $parameters['capacity']=$cinemaToUpdate->getcapacity();


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
     $cinema->setnameCinema($result[0]->getnameCinema());
     $cinema->setaddress($result[0]->getaddress());
     $cinema->setopeningTime($result[0]->getopeningTime());
     $cinema->setclosingTime($result[0]->getclosingTime());
     $cinema->setticketValue($result[0]->getticketValue()); 
     $cinema->setcapacity($result[0]->getcapacity());
     $cinema->setidCinema($result[0]->getidCinema());
     $cinema->setdeleteCinema($result[0]=0);
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

