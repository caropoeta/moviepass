<?php

namespace DAO;

use Models\Room as Room;
use \Exception as Exception;


class RoomDAO
{

    public function readAllByCinema($cinemaId){
        $sql = "SELECT * FROM $this->tablename WHERE idCinema = :idCinema";
        $parameter['idCinema'] = $cinemaId;

        try
        {
            $this->connection = Connection::getInstance();
            $resultSet = $this->connection->execute($sql,$parameter);
            if (!empty($resultSet))
                return $this->mapear($resultSet);
             else 
                 return false; 
        }
        catch(Exception $e)
        {
            echo $e;
        }
    }

    protected function mapear($value) 
    {
        $roomList = array();
        foreach($value as $v){
            $room = new Room();
            $room->setName($v['roomName']);
            $room->setCapacity($v['capacity']);
            $room->setPrice($v['Price']);
            $room->setId($v['idRoom']);
            $cinema = $this->cinemaDBDAO->read($v['idCinema']);
            $room->setCinema($cinema);
            array_push($roomList,$room);
        }
        if(count($roomList)>0)
            return $roomList;
        else
            return false;
     }
  

    public function Add($room){

        $sql = "INSERT INTO $this->tablename (roomName,capacity,price,idCinema) VALUES (:roomName,:capacity,price,:idCinema)";

        $parameters['roomName'] = $room->getName();
        $parameters['capacity'] = $room->getCapacity();
        $parameters['price']= $room->getprice();
        $parameters['idCinema'] = $room->getCinema()->getId();

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

    public function Update($room){

        $sql = "UPDATE $this->tablename SET roomName = :roomName , price = :price , capacity = :capacity  WHERE idRoom = :idRoom";
        
        $parameters['roomName'] = $room->getName();
        $parameters['capacity'] = $room->getCapacity();
        $parameters['price']=$room->getPrice();
        $parameters['idRoom'] = $room->getId();
  
        try{
          $this->connection = Connection::getInstance();
          return $this->connection->ExecuteNonQuery($sql, $parameters);
        }
        catch(Exception $e){
          echo $e;
        }
      }

        public function Remove($id){
            $sql = "DELETE FROM $this->tablename WHERE idRoom = :idRoom";
            $parameters['idRoom'] = $id;
            
            try{
                $this->connection = Connection::getInstance();
                return $this->connection->ExecuteNonQuery($sql, $parameters);
            }
            catch(Exception $e){
                echo $e;
            }
        }
        public function read ($id)
        {
            $sql = "SELECT * FROM $this->tablename where idRoom = :idRoom";
            $parameters['idRoom'] = $id;
            try
            {
                $this->connection = Connection::getInstance();
                $resultSet = $this->connection->execute($sql, $parameters);
                if(!empty($resultSet))
                {
                     $response = $this->mapear($resultSet);
                     return $response[0];  
                 }else
                    return false;
            }
            catch(Exception $e)
            {
                echo $e;
            }
        }
    
        public function existsByName ($room)
        {
            $sql = "SELECT * FROM $this->tablename where roomName = :roomName and idCinema = :idCinema";
            $parameters['roomName'] = $room->getName();
            $parameters['idCinema'] = $room->getCinema()->getId();
            try
            {
                $this->connection = Connection::getInstance();
                $resultSet = $this->connection->ExecuteNonQuery($sql, $parameters);
                if(!empty($resultSet))
                {
                    return true;  
                 }else
                    return false;
            }
            catch(Exception $e)
            {
                echo $e;
            }
            
        }

  
}