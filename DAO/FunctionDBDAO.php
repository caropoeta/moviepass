<?php
namespace DAO;
use DAO\Connection;
use \PDO as PDO;
use \Exception as Exception;
use DAO\QueryType as QueryType;
use Models\FilmFunction as FilmFunction;
use Models\Room as Room;
use PDOException;

class FunctionDBDAO
{

 private $connection;


 public function __construct()
 {
  $this->connection = null;
}


public function readAllByRoom($roomId){

  $sql = "SELECT * FROM  movieFunctions  where deleteFunction=0 and idRoom =:roomId";
  $parameters['roomId'] = $roomId;

  try
  {
    $this->connection = Connection::getInstance();
    $resultSet = $this->connection->Execute($sql,$parameters);
    if (!empty($resultSet))
      return $this->Mapear($resultSet);
    else 
     return false; 
 } catch(Exception $e)
        {
            echo $e;
        }
    }


protected function Mapear($value) 
{
  $functionList = array();
  foreach($value as $v){
    $filmFunction = new FilmFunction();

    $filmFunction->setStartFunction($v['startFunction']);
    $filmFunction->setAssistance($v['assistance']);
    $filmFunction->setDeleteFunction($v['deleteFunction']);
    $filmFunction->setIdRoom($v['idRoom']);
    $filmFunction->setIdMovieFunction($v['idMovieFunction']);
    $filmFunction->setIdMovie($v['idMovie']);
    $filmFunction->setDaysOfWeek($v['daysOfWeek']);
    
    array_push($functionList,$filmFunction);
  }
  if(count($functionList)>0)
    return $functionList;
  else
    return false;
}


public function AddFunction($function){

        $sql = "INSERT INTO movieFunctions (startFunction,assistance,deleteFunction,daysOfWeek,idRoom,idMovie) VALUES (:startFunction,:assistance,:deleteFunction,:daysOfWeek,:idRoom,:idMovie)";

        $parameters['startFunction'] = $function->getStartFunction();
        $parameters['assistance'] = $function->getAssistance();
        $parameters['deleteFunction']= $function->getDeleteFunction();
        $parameters['daysOfWeek']=$function->getDaysOfWeek();
        $parameters['idRoom']=$function->getIdRoom();
        $parameters['idMovie']=$function->getIdMovie();

        try
        {
                $this->connection = Connection::getInstance();
                $result = $this->connection->ExecuteNonQuery($sql, $parameters);
                if($result)
                    return $result;
                else
                 return false;
                
         }
        catch(Exception $e)
        {
            echo $e;
        }
    }
     public function Update($function){

        $sql = "UPDATE function SET startFunction = :startFunction, assistance = :assistance, deleteFunction= :deleteFunction  WHERE idMovieFunction= :idMovieFunction";
        
        $parameters['startFunction'] = $function->getStartFunction();
        $parameters['assistance'] = $function->getAssistance();
        $parameters['deleteFunction']=$function->getDeleteFunction();
        
    
  
        try{
          $this->connection = Connection::getInstance();
          return $this->connection->ExecuteNonQuery($sql, $parameters);
        }
        catch(Exception $e){
          echo $e;
        }
      }

}

