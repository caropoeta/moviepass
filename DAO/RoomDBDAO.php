<?php

namespace DAO;

use Models\Room as Room;
use DAO\CinemaDBDAO as CinemaDBDAO;
use \Exception as Exception;
use Models\Cinema;

class RoomDBDAO
{
    private $cinemaDBDAO;

    public function __construct() {
        $this->cinemaDBDAO = new CinemaDBDAO();
    }

    public function readAllByCinema($cinemaId){
        $sql = "SELECT * FROM rooms WHERE idCinema = :idCinema and deleted = 0";
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

    public static function getCinemaByRoomId(int $roomid)
    {
        $conection = Connection::GetInstance();
        $query = "
        select idCinema from rooms where idRoom = :idRoom;";
        $response = $conection->Execute($query, array('idRoom' => $roomid));

        $roleArray = array_map(function (array $obj) {
            return $obj['idCinema'];
        }, $response);

        $cinema = new CinemaDBDAO();

        $responseCin = [];
        foreach ($roleArray as $value) {
            array_push($responseCin, $cinema->Read($value));
        }        

        return ((isset($responseCin[0])) ? $responseCin[0] : null);
    }

    protected function mapear($value) 
    {
        $roomList = array();
        foreach($value as $v){
            $room = new Room();
            $room->setName($v['roomName']);
            $room->setCapacity($v['capacity']);
            $room->setPrice($v['price']);
            $room->setId($v['idRoom']);
            $room->setCinema($this->cinemaDBDAO->read($v['idCinema']));
            array_push($roomList,$room);
        }
        if(count($roomList)>0)
            return $roomList;
        else
            return false;
     }
  

    public function Add($room){

        $sql = "INSERT INTO rooms (roomName,capacity,price,idCinema) VALUES (:roomName,:capacity,:price,:idCinema)";

        $parameters['roomName'] = $room->getName();
        $parameters['capacity'] = $room->getCapacity();
        $parameters['price']= $room->getprice();
        $parameters['idCinema'] = $room->getCinema()->getidCinema();

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

        $sql = "UPDATE rooms SET roomName = :roomName , price = :price , capacity = :capacity  WHERE idRoom = :idRoom";
        
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
            $sql = "update rooms set deleted = 1 WHERE idRoom = :idRoom";
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
            $sql = "SELECT * FROM rooms where idRoom = :idRoom";
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
            $sql = "SELECT * FROM rooms where roomName = :roomName and idCinema = :idCinema";
            $parameters['roomName'] = $room->getName();
            $parameters['idCinema'] = $room->getCinema()->getidCinema();
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